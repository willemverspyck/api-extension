<?php

declare(strict_types=1);

namespace Spyck\ApiExtension\Service;

use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Spyck\ApiExtension\Map\MapInterface;
use Spyck\ApiExtension\Model\ConfigInterface;
use Spyck\ApiExtension\Model\Pagination;
use Spyck\ApiExtension\Model\Response;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

final class ResponseService
{
    private const PREVIOUS = 'previous';
    private const NEXT = 'next';

    public function __construct(private readonly PaginatorInterface $paginator, private readonly RequestStack $requestStack, private readonly RouterInterface $router)
    {
    }

    public function getResponse(QueryBuilder $queryBuilder, MapInterface $requestList, ConfigInterface $config): Response
    {
        $paginate = $this->paginator->paginate($queryBuilder, $requestList->getPage(), $requestList->getPageSize());

        $pagination = new Pagination();
        $pagination->setNext($this->getPage($paginate, self::NEXT));
        $pagination->setPrevious($this->getPage($paginate, self::PREVIOUS));

        $response = new Response();
        $response->setConfig($config);
        $response->setData($paginate->getItems());
        $response->setTotal($paginate->getTotalItemCount());
        $response->setPagination($pagination);

        return $response;
    }

    private function getPage(PaginationInterface $pagination, string $name): ?string
    {
        $data = $pagination->getPaginationData();

        if (array_key_exists($name, $data)) {
            $request = $this->requestStack->getCurrentRequest();

            $route = $pagination->getRoute();

            $parameters = array_merge($request->query->all(), $request->attributes->get('_route_params'));
            $parameters['page'] = $data[$name];

            return $this->router->generate($route, $parameters, UrlGeneratorInterface::ABSOLUTE_URL);
        }

        return null;
    }
}

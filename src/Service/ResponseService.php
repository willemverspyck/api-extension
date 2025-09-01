<?php

declare(strict_types=1);

namespace Spyck\ApiExtension\Service;

use Doctrine\ORM\QueryBuilder;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Spyck\ApiExtension\Map\MapInterface;
use Spyck\ApiExtension\Map\PaginationMapInterface;
use Spyck\ApiExtension\Model\ConfigInterface;
use Spyck\ApiExtension\Model\Pagination;
use Spyck\ApiExtension\Model\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

final class ResponseService
{
    private const string PREVIOUS = 'previous';
    private const string NEXT = 'next';

    public function __construct(private readonly PaginatorInterface $paginator, private readonly RequestStack $requestStack, private readonly RouterInterface $router, private readonly SerializerInterface $serializer)
    {
    }

    public function getResponseForItem(?object $data = null, array $groups = []): JsonResponse
    {
        if (null === $data) {
            $error = 'Not found';

            return new JsonResponse(data: $error, status: HttpFoundationResponse::HTTP_NOT_FOUND);
        }

        $data = $this->serializer->serialize(data: $data, format: 'json', context: $this->getContext($groups));

        return new JsonResponse(data: $data, json: true);
    }

    public function getResponseForList(array|QueryBuilder $data, ?MapInterface $map = null, ?ConfigInterface $config = null, array $groups = []): JsonResponse
    {
        $response = $this->getResponse($data, $map, $config);

        return new JsonResponse(data: $this->serializer->serialize($response, 'json', $this->getContext($groups)), json: true);
    }

    private function getResponse(array|QueryBuilder $data, ?MapInterface $map = null, ?ConfigInterface $config = null): Response
    {
        $response = new Response();
        $response->setConfig($config);

        if ($map instanceof PaginationMapInterface) {
            $paginate = $this->paginator->paginate($data, $map->getPage(), $map->getPageSize());

            $pagination = new Pagination();
            $pagination->setNext($this->getPage($paginate, self::NEXT));
            $pagination->setPrevious($this->getPage($paginate, self::PREVIOUS));

            $response->setData($paginate->getItems());
            $response->setTotal($paginate->getTotalItemCount());
            $response->setPagination($pagination);

            return $response;
        }

        if ($data instanceof QueryBuilder) {
            $data = $data->getQuery()->getResult();
        }

        $response->setData($data);
        $response->setTotal(count($data));

        return $response;
    }

    private function getContext(array $groups): array
    {
        $groups[] = Response::GROUP;

        return [
            AbstractNormalizer::GROUPS => $groups,
            JsonEncode::OPTIONS => JsonResponse::DEFAULT_ENCODING_OPTIONS,
        ];
    }

    private function getPage(SlidingPaginationInterface $pagination, string $name): ?string
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

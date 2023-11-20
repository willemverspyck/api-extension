<?php

declare(strict_types=1);

namespace Spyck\ApiExtension\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as BaseAbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

abstract class AbstractController extends BaseAbstractController
{
    protected function getResponseForItem(object $data = null, array $groups = []): JsonResponse
    {
        if (null === $data) {
            $error = [
                'Item not found',
            ];

            return $this->json($error, Response::HTTP_NOT_FOUND, [], [
                AbstractNormalizer::GROUPS => $groups,
            ]);
        }

        return $this->json($data, Response::HTTP_OK, [], [
            AbstractNormalizer::GROUPS => $groups,
        ]);
    }

    protected function getResponseForList(object $data, array $groups = []): JsonResponse
    {
        return $this->json($data, Response::HTTP_OK, [], [
            AbstractNormalizer::GROUPS => $groups,
        ]);
    }
}

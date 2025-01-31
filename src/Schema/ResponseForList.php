<?php

declare(strict_types=1);

namespace Spyck\ApiExtension\Schema;

use Attribute;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes\Items;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Response;
use Spyck\ApiExtension\Model\ConfigInterface;
use Spyck\ApiExtension\Model\Pagination;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
final class ResponseForList extends Response
{
    public function __construct(string $type, ?array $groups = null)
    {
        parent::__construct(response: HttpFoundationResponse::HTTP_OK, description: 'Response object with multiple items', content: new JsonContent(properties: [
            new Property(property: 'config', ref: new Model(type: ConfigInterface::class)),
            new Property(property: 'data', type: 'array', items: new Items(ref: new Model(type: $type, groups: $groups))),
            new Property(property: 'total', type: 'integer'),
            new Property(property: 'pagination', ref: new Model(type: Pagination::class)),
        ], type: 'object'));
    }
}

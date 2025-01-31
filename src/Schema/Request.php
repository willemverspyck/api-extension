<?php

declare(strict_types=1);

namespace Spyck\ApiExtension\Schema;

use Attribute;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\RequestBody;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
final class Request extends RequestBody
{
    public function __construct(string $type, ?array $groups = null)
    {
        parent::__construct(content: new JsonContent(ref: new Model(type: $type, groups: $groups)));
    }
}

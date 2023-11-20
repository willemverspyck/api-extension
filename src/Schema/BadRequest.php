<?php

declare(strict_types=1);

namespace Spyck\ApiExtension\Schema;

use Attribute;
use OpenApi\Attributes\Response;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
final class BadRequest extends Response
{
    public function __construct()
    {
        parent::__construct(response: HttpFoundationResponse::HTTP_BAD_REQUEST, description: 'Bad request');
    }
}

<?php

declare(strict_types=1);

namespace Spyck\ApiExtension\Map;

use OpenApi\Attributes as OpenApi;
use Symfony\Component\Validator\Constraints as Validator;

trait QueryMapTrait
{
    #[OpenApi\QueryParameter(name: 'query', description: 'Query as filter')]
    #[Validator\Type(type: 'string')]
    private ?string $query = null;

    public function getQuery(): ?string
    {
        return $this->query;
    }

    public function setQuery(?string $query): self
    {
        $this->query = $query;

        return $this;
    }
}

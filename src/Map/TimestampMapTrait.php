<?php

declare(strict_types=1);

namespace Spyck\ApiExtension\Map;

use OpenApi\Attributes as OpenApi;
use Symfony\Component\Validator\Constraints as Validator;

trait TimestampMapTrait
{
    #[OpenApi\QueryParameter(name: 'timestamp', description: 'Timestamp as filter')]
    #[Validator\Valid]
    private ?Timestamp $timestamp = null;

    public function getTimestamp(): ?Timestamp
    {
        return $this->timestamp;
    }

    public function setTimestamp(?string $timestamp): self
    {
        $this->timestamp = $timestamp;

        return $this;
    }
}

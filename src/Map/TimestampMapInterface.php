<?php

declare(strict_types=1);

namespace Spyck\ApiExtension\Map;

interface TimestampMapInterface extends MapInterface
{
    public function getTimestamp(): ?Timestamp;

    public function setTimestamp(?string $timestamp): self;
}

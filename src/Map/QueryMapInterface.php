<?php

declare(strict_types=1);

namespace Spyck\ApiExtension\Map;

interface QueryMapInterface extends MapInterface
{
    public function getQuery(): ?string;

    public function setQuery(?string $query): self;
}

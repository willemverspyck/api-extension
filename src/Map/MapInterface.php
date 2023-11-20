<?php

declare(strict_types=1);

namespace Spyck\ApiExtension\Map;

interface MapInterface
{
    public function getPage(): int;

    public function setPage(int $page): self;

    public function getPageSize(): int;

    public function setPageSize(int $pageSize): self;
}

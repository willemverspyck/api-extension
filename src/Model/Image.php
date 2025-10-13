<?php

declare(strict_types=1);

namespace Spyck\ApiExtension\Model;

final class Image
{
    public function __construct(private readonly object $object, private readonly ?string $field = null, private readonly ?string $filter = null)
    {
    }

    public function getObject(): object
    {
        return $this->object;
    }

    public function getField(): ?string
    {
        return $this->field;
    }

    public function getFilter(): ?string
    {
        return $this->filter;
    }
}

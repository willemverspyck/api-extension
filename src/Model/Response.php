<?php

declare(strict_types=1);

namespace Spyck\ApiExtension\Model;

use Symfony\Component\Serializer\Annotation as Serializer;

final class Response
{
    public const GROUP = 'spyck:api:extension';

    #[Serializer\Groups(groups: self::GROUP)]
    private ?ConfigInterface $config = null;

    #[Serializer\Groups(groups: self::GROUP)]
    private iterable $data;

    #[Serializer\Groups(groups: self::GROUP)]
    private int $total;

    #[Serializer\Groups(groups: self::GROUP)]
    private ?Pagination $pagination = null;

    public function getConfig(): ?ConfigInterface
    {
        return $this->config;
    }

    public function setConfig(?ConfigInterface $config): static
    {
        $this->config = $config;

        return $this;
    }

    public function getData(): iterable
    {
        return $this->data;
    }

    public function setData(iterable $data): static
    {
        $this->data = $data;

        return $this;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function setTotal(int $total): static
    {
        $this->total = $total;

        return $this;
    }

    public function getPagination(): ?Pagination
    {
        return $this->pagination;
    }

    public function setPagination(?Pagination $pagination): static
    {
        $this->pagination = $pagination;

        return $this;
    }
}

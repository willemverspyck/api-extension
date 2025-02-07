<?php

declare(strict_types=1);

namespace Spyck\ApiExtension\Model;

use Symfony\Component\Serializer\Attribute as Serializer;

final class Pagination
{
    #[Serializer\Groups(groups: Response::GROUP)]
    private ?string $next = null;

    #[Serializer\Groups(groups: Response::GROUP)]
    private ?string $previous = null;

    public function getNext(): ?string
    {
        return $this->next;
    }

    public function setNext(?string $next): static
    {
        $this->next = $next;

        return $this;
    }

    public function getPrevious(): ?string
    {
        return $this->previous;
    }

    public function setPrevious(?string $previous): static
    {
        $this->previous = $previous;

        return $this;
    }
}

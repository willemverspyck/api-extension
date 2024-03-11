<?php

declare(strict_types=1);

namespace Spyck\ApiExtension\Map;

use OpenApi\Attributes as OpenApi;
use Symfony\Component\Validator\Constraints as Validator;

trait PaginationMapTrait
{
    #[OpenApi\QueryParameter(name: 'page', description: 'Page for pagination')]
    #[Validator\Range(minMessage: 'This value should be greater or equal to 1', min: 1)]
    private int $page = 1;

    #[OpenApi\QueryParameter(name: 'pageSize', description: 'Page size for pagination')]
    #[Validator\Range(notInRangeMessage: 'This value should be between 1 and 50', invalidMessage: 'This value is not valid', min: 1, max: 50)]
    private int $pageSize = 50;

    public function getPage(): int
    {
        return $this->page;
    }

    public function setPage(int $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    public function setPageSize(int $pageSize): self
    {
        $this->pageSize = $pageSize;

        return $this;
    }
}

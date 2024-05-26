<?php

namespace App\DTO;

class PaginatorDTO extends BaseDTO
{
    public ?int $perPage = null;
    public ?int $page = null;
    public ?int $total = null;

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function getPage():int
    {
        return max($this->page, 1);
    }

    /**
     * @return int|null
     */
    public function getTotal(): ?int
    {
        return $this->total;
    }
}

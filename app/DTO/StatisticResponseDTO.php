<?php

namespace App\DTO;

use Illuminate\Support\Collection;

class StatisticResponseDTO extends BaseDTO
{
    public ?Collection $statistics = null;
    public ?PaginatorDTO $paginator = null;

    public function setStatistics(Collection $statistics): self
    {
        $this->statistics = $statistics;
        return $this;
    }

    public function setPaginator(PaginatorDTO $paginator): self
    {
        $this->paginator = $paginator;
        return $this;
    }

    public function getStatistics(): Collection
    {
        return $this->statistics;
    }

    public function getPaginator(): PaginatorDTO
    {
        return $this->paginator;
    }
}

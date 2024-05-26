<?php

namespace App\DTO;

use Illuminate\Support\Collection;

/**
 * @property Collection $data
 * @property PaginatorDTO $paginator
 */
class ResponseDTO extends BaseDTO
{
    public ?Collection $data = null;
    public ?PaginatorDTO $paginator = null;

    public function setData(Collection $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function setPaginator(PaginatorDTO $paginator): self
    {
        $this->paginator = $paginator;
        return $this;
    }

    public function getData(): Collection
    {
        return $this->data;
    }

    public function getPaginator(): PaginatorDTO
    {
        return $this->paginator;
    }
}

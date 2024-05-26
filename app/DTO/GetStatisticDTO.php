<?php

namespace App\DTO;

class GetStatisticDTO extends BaseDTO
{
    public ?string $dateFrom = null;
    public ?string $dateTo = null;
    public ?string $direction = null;
    public ?string $sortBy = null;
    public ?int $perPage = null;
    public ?int $page = null;

    public function getStartDate(): ?string
    {
        return $this->dateFrom ?? null;
    }

    public function getEndDate(): ?string
    {
        return $this->dateTo ?? null;
    }

    public function getDirection(): string
    {
        return $this->direction ?? 'desc';
    }

    public function getSortBy(): string
    {
        return $this->sortBy ?? 'collected_at';
    }

    public function getPerPage(): int
    {
        return $this->perPage ?? 10;
    }

    public function getOffset(): int
    {
        return ($this->page - 1) * $this->perPage;
    }

    public function getPage(): ?int
    {
        return $this->page ?? 1;
    }
}

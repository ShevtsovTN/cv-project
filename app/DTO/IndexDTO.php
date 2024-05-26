<?php

namespace App\DTO;

use App\Enums\PaginationEnum;

/**
 * @property string search
 * @property string sortBy
 * @property string direction
 * @property int page
 * @property int perPage
 */
class IndexDTO extends BaseDTO
{
    public ?string $search = null;
    public ?string $sortBy = null;
    public ?string $direction = null;
    public ?int $page = null;
    public ?int $perPage = null;

    /**
     * @return string
     */
    public function getDirection(): string
    {
        return $this->direction ?? 'desc';
    }

    /**
     * @return string|null
     */
    public function getSearch(): ?string
    {
        return $this->search ?? null;
    }

    /**
     * @return string
     */
    public function getSortBy(): string
    {
        return $this->sortBy ?? 'id';
    }

    public function getPerPage(): int
    {
        return $this->perPage ?? PaginationEnum::PER_PAGE_10->value;
    }

    public function getOffset(): int
    {
        return ($this->getPage() - 1) * $this->getPerPage();
    }

    public function getPage(): ?int
    {
        return $this->page ?? 1;
    }
}

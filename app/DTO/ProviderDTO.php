<?php

namespace App\DTO;

class ProviderDTO extends BaseDTO
{
    public ?int $id;
    public ?string $name;
    public ?bool $active;
    public ?string $created_at;
    public ?string $updated_at;
}

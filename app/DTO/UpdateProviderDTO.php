<?php

namespace App\DTO;

class UpdateProviderDTO extends BaseDTO
{
    public ?int $id;
    public ?string $name;
    public ?bool $active;
}

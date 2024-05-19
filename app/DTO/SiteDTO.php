<?php

namespace App\DTO;

class SiteDTO extends BaseDTO
{
    public ?int $id;
    public ?string $name;
    public ?string $url;
    public ?string $provider_key;
    public ?string $created_at;
    public ?string $updated_at;
}

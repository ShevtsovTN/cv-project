<?php

namespace App\DTO;

class UpdateSiteDTO extends BaseDTO
{
    public ?int $id;
    public ?string $name;
    public ?string $url;
    public ?string $provider_key;
}

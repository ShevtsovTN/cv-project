<?php

namespace App\DTO;

class UpdateProviderSiteDTO extends BaseDTO
{
    public ?bool $active;
    public ?string $external_id;
}

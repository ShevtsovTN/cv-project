<?php

namespace App\DTO;

use App\DTO\BaseDTO;

class AttachSiteDTO extends BaseDTO
{
    public ?int $site_id;
    public ?bool $active;
    public ?string $external_id;
}

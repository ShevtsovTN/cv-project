<?php

namespace App\Interfaces\Example;

use App\Interfaces\ProviderRepositoryInterface;

interface ProviderConfigInterface
{
    public function setAttributes(string $techName): void;

    public function getProviderRepository(): ProviderRepositoryInterface;

    public function getId(): int;
}

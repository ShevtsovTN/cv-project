<?php

namespace App\StatisticEntities;

use App\Interfaces\Example\ProviderConfigInterface;
use App\Interfaces\ProviderRepositoryInterface;
use ReflectionClass;

class BaseProviderConfig implements ProviderConfigInterface
{
    protected int $id;

    protected bool $active;

    public function __construct(
        public ProviderRepositoryInterface $providerRepository,
        public string $techName
    )
    {
        $providerDTO = $this->providerRepository->getByTechName($this->techName);
        $this->active = (bool) $providerDTO?->active;
        $this->id = (int) $providerDTO?->id;
        $this->setAttributes($this->techName);
    }

    public function setAttributes(string $techName): void
    {
        $config = config('api.'.$techName);

        $reflect = new ReflectionClass($this);

        foreach ($config as $key => $value) {
            if ($reflect->hasProperty($key) && $reflect->getProperty($key)->isPublic()) {
                $this->{$key} = $value;
            }
        }
    }

    public function getProviderRepository(): ProviderRepositoryInterface
    {
        return $this->providerRepository;
    }

    public function getId(): int
    {
        return $this->id;
    }
}

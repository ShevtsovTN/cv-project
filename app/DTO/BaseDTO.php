<?php

namespace App\DTO;

use ReflectionClass;
use ReflectionProperty;

class BaseDTO
{
    public function __construct(array $attributes = [])
    {
        $this->setAttributes($attributes);
    }

    public function toArray(): array
    {
        $result = [];
        $reflect = new ReflectionClass($this);

        foreach ($reflect->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $name = $property->getName();
            $result[$name] = $this->{$name} ?? null;
        }

        return $result;
    }

    public function setAttributes(array $attributes): self
    {

        if (empty($attributes)) {
            return $this;
        }

        $reflect = new ReflectionClass($this);

        foreach ($attributes as $key => $value) {
            if ($reflect->hasProperty($key) && $reflect->getProperty($key)->isPublic()) {
                $this->{$key} = $value;
            }
        }

        return $this;
    }
}

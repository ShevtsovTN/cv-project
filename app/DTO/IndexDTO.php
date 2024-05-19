<?php

namespace App\DTO;

use ReflectionClass;

/**
 * @property string search
 * @property string sort
 * @property string direction
 * @property int page
 * @property int per_page
 */
class IndexDTO extends BaseDTO
{
    public string $search;
    public string $sort;
    public string $direction;
    public int $page;
    public int $per_page;
}

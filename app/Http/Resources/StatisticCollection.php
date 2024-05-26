<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class StatisticCollection extends ResourceCollection
{
    public $collects = StatisticResource::class;
}

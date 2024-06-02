<?php

namespace App\Helpers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\App;
use Random\RandomException;
use RuntimeException;

readonly class DatetimeHelper
{
    public function __construct(public CarbonImmutable $dateFrom, public CarbonImmutable $dateTo)
    {
        if ($dateFrom->greaterThan($dateTo)) {
            throw new RuntimeException('Invalid datetime interval.', 400);
        }

        if ($dateFrom->timezoneName !== $dateTo->timezoneName || $dateFrom->offsetHours !== $dateTo->offsetHours) {
            throw new RuntimeException('Different timezones.', 400);
        }
    }

    /**
     * @throws RuntimeException
     */
    public function getTimezone(): string
    {
        return $this->dateFrom->timezoneName;
    }

    /**
     * @throws RandomException
     */
    public function getRandomDate(): CarbonImmutable
    {
        if (App::isProduction()) {
            throw new RandomException('Random date is not allowed in production.', 400);
        }

        $interval = $this->dateFrom->diffInHours($this->dateTo);
        $randomHours = random_int(0, $interval);
        return $this->dateFrom->addHours($randomHours);
    }
}

<?php

namespace App\Helpers;

use Illuminate\Support\Carbon;
use InvalidArgumentException;

class DatetimeHelper
{
    private int $dateFrom;
    private int $dateTo;
    private string $tz;
    public function __construct(
        ?int $dateFrom = null,
        ?int $dateTo = null,
        ?string $tz = 'UTC'
    )
    {
        if (!$this->checkTimezone($tz)) {
            throw new InvalidArgumentException('Invalid timezone');
        }

        $this->tz = $tz;
        $this->dateFrom = $dateFrom ?? Carbon::now($tz)->startOfDay()->timestamp;
        $this->dateTo = $dateTo ?? Carbon::now($tz)->endOfDay()->timestamp;

        if (!$this->validateInterval($this->dateFrom, $this->dateTo)) {
            throw new InvalidArgumentException('Invalid interval');
        }
    }

    public function dateFrom(): int
    {
        return $this->dateFrom;
    }

    public function dateTo(): int
    {
        return $this->dateTo;
    }

    public function getIntervalWithFormat(string $format): array
    {
        $start = Carbon::createFromTimestamp($this->dateFrom, $this->tz)->format($format);
        $end = Carbon::createFromTimestamp($this->dateTo, $this->tz)->format($format);

        return [$start, $end];
    }

    public function getInterval(): array
    {
        return [$this->dateFrom, $this->dateTo];
    }

    private function checkTimezone(string $tz): bool
    {
        return in_array($tz, timezone_identifiers_list(), true);
    }

    private function validateInterval(int $dateFrom, int $dateTo): bool
    {
        return $dateTo > $dateFrom;
    }

    public function tz(): ?string
    {
        return $this->tz;
    }
}

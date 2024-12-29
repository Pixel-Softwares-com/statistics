<?php

namespace Statistics\DateProcessors\DateProcessorTypes\DateGroupedChartDateProcessors;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;

class SemiAnnaulPeriodDateProcessor extends DateGroupedChartDateProcessor
{
    const SemiAnnualLengthToSUB = 8; // Adjust for how many semi-annual periods you want to calculate (default: last 4 years)

    /**
     * Get the starting date for the semi-annual period calculation.
     */
    public function getStartingDateInstance(): Carbon
    {
        $endingDate = $this->endingDate ?? $this->getEndingDateInstance();
        return Carbon::make($endingDate)->subMonths(static::SemiAnnualLengthToSUB * 6)->startOfMonth();
    }

    /**
     * Get the ending date for the semi-annual period calculation.
     */
    public function getEndingDateInstance(): Carbon
    {
        return Carbon::parseOrNow($this->getStartingDateRequestValue())->endOfMonth();
    }

    /**
     * Format a single date as a semi-annual period (e.g., "2024-H1" or "2024-H2").
     */
    protected function getPeriodSingleDateFormat(Carbon $singleDate): string
    {
        $semiAnnual = ceil($singleDate->month / 6); // Determine if the date is in H1 or H2
        return $singleDate->year . "-H" . $semiAnnual;
    }

    /**
     * Define the interval between periods as 6 months.
     */
    protected function getPeriodInterval(): CarbonInterval
    {
        return CarbonInterval::make("6 months");
    }
}

<?php

namespace Statistics\DateProcessors\DateProcessorTypes\DateGroupedChartDateProcessors;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;

class SemiAnnaulPeriodDateProcessor extends DateGroupedChartDateProcessor
{
    const YearLengthToSUB = 2;
    public function getStartingDateInstance(): Carbon
    {
        $endingDate = $this->endingDate ?? $this->getEndingDateInstance();
        return Carbon::make($endingDate)->subYears(static::YearLengthToSUB)->startOfYear();
    }

    public function getEndingDateInstance(): Carbon
    {
        return Carbon::parseOrNow($this->getStartingDateRequestValue())->endOfYear();
    }

    protected function getPeriodSingleDateFormat(Carbon $singleDate): string
    {
        $month = $singleDate->month;
        $half = ($month <= 6) ? 'H1' : 'H2'; // H1 for first half, H2 for second half
        return $singleDate->format("Y") . " " . $half;
    }

    protected function getPeriodInterval(): CarbonInterval
    {
        return CarbonInterval::months(6); // Interval for 6 months
    }

}

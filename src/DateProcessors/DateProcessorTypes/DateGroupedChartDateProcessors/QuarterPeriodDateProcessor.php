<?php

namespace Statistics\DateProcessors\DateProcessorTypes\DateGroupedChartDateProcessors;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;

class QuarterPeriodDateProcessor extends DateGroupedChartDateProcessor
{
    const QuarterLengthToSUB = 16 ;
    public function getStartingDateInstance(): Carbon
    {
        $endingDate = $this->endingDate ?? $this->getEndingDateInstance();
        return Carbon::make($endingDate)->subQuarters(static::QuarterLengthToSUB)->startOfQuarter();
    }

    public function getEndingDateInstance(): Carbon
    {
        return Carbon::parseOrNow($this->getStartingDateRequestValue())->endOfQuarter();
    }

    protected function getPeriodSingleDateFormat(Carbon $singleDate): string
    {
        $quarter = ceil($singleDate->month / 3);
        return $singleDate->year . "-Q" . $quarter;
    }

    protected function getPeriodInterval() : CarbonInterval
    {
        return CarbonInterval::make("1 quarters");
    }
}

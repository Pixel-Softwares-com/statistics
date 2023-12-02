<?php

namespace Statistics\DateProcessors\DateProcessorTypes\DateGroupedChartDateProcessors;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;

class YearPeriodDateProcessor extends DateGroupedChartDateProcessor
{
    const YearLengthToSUB = 4 ;
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
        return $singleDate->format("Y");
    }
    protected function getPeriodInterval( ) : CarbonInterval
    {
        return CarbonInterval::years(1);
    }
}

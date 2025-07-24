<?php

namespace Statistics\DateProcessors\DateProcessorTypes\DateGroupedChartDateProcessors;

use Carbon\Carbon;
use Carbon\CarbonInterval;

class DayPeriodDateProcessor extends DateGroupedChartDateProcessor
{
    const DayLengthToSUB = 14 ;
    
    public function getStartingDateInstance(): Carbon
    {
        $endingDate = $this->endingDate ?? $this->getEndingDateInstance();
        return Carbon::make($endingDate)->subDays(static::DayLengthToSUB)->startOfDay();
    }

    public function getEndingDateInstance(): Carbon
    {
        return Carbon::parseOrNow($this->getStartingDateRequestValue())->endOfDay();
    }

    protected function getPeriodSingleDateFormat(Carbon $singleDate): string
    {
        return $singleDate->format("F-j");
    }
    
    protected function getPeriodInterval( ) : CarbonInterval
    {
        return CarbonInterval::days(1);
    }
}

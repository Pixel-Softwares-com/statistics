<?php

namespace Statistics\DateProcessors\DateProcessorTypes\DateGroupedChartDateProcessors;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;

class MonthPeriodDateProcessor extends DateGroupedChartDateProcessor
{
    const MonthLengthToSUB = 12 ;

    public function getStartingDateInstance(): Carbon
    {
        $endingDate = $this->endingDate ?? $this->getEndingDateInstance();
        return Carbon::make($endingDate)->subMonths(static::MonthLengthToSUB)->startOfMonth();
    }

    public function getEndingDateInstance(): Carbon
    {
        return Carbon::parseOrNow($this->getStartingDateRequestValue())->endOfMonth();
    }
    
    protected function getPeriodSingleDateFormat(Carbon $singleDate): string
    {
        return $singleDate->format("Y-n");
    }

    protected function getPeriodInterval( ) : CarbonInterval
    {
        return CarbonInterval::months(1);
    }
}

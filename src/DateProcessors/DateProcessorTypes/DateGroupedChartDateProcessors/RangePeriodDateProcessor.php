<?php

namespace Statistics\DateProcessors\DateProcessorTypes\DateGroupedChartDateProcessors;

use Statistics\DateProcessors\DateProcessor;
use Carbon\Carbon;

class RangePeriodDateProcessor extends DateProcessor
{

    public function getStartingDateInstance(): Carbon
    {
        return Carbon::parseOrNow($this->getStartingDateRequestValue());
    }

    public function getEndingDateInstance(): Carbon
    {
        return Carbon::parseOrNow($this->getEndingDateRequestValue());
    }

    public function getPeriodLengthByDays() : int
    {
        return (int) $this->getStartingDate()->diffInDays( $this->getEndingDate() );
    }
}

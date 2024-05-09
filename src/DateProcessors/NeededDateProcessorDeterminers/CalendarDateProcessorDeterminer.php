<?php

namespace Statistics\DateProcessors\NeededDateProcessorDeterminers;

use Statistics\DateProcessors\DateProcessor;
use Statistics\DateProcessors\DateProcessorTypes\GlobalDateProcessors\DayPeriodDateProcessor;
use Statistics\DateProcessors\DateProcessorTypes\GlobalDateProcessors\MonthPeriodDateProcessor;
use Statistics\DateProcessors\DateProcessorTypes\GlobalDateProcessors\QuarterPeriodDateProcessor;
use Statistics\DateProcessors\DateProcessorTypes\GlobalDateProcessors\RangePeriodDateProcessor;
use Statistics\DateProcessors\DateProcessorTypes\GlobalDateProcessors\YearPeriodDateProcessor;

class CalendarDateProcessorDeterminer extends NeededDateProcessorDeterminer
{
    public function getDateProcessorInstance(): DateProcessor|null
    {
        return (match($this->getPeriodTypeRequestValue())
        {
            'range'     => RangePeriodDateProcessor::Singleton($this::$request),
            default     => null, /** for all time date filter (we don't want to set date filter) */
        });
    }
}

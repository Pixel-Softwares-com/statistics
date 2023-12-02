<?php

namespace Statistics\DateProcessors\NeededDateProcessorDeterminers;

use Statistics\DateProcessors\DateProcessor;
use Statistics\DateProcessors\DateProcessorTypes\GlobalDateProcessors\DayPeriodDateProcessor;
use Statistics\DateProcessors\DateProcessorTypes\GlobalDateProcessors\MonthPeriodDateProcessor;
use Statistics\DateProcessors\DateProcessorTypes\GlobalDateProcessors\QuarterPeriodDateProcessor;
use Statistics\DateProcessors\DateProcessorTypes\GlobalDateProcessors\RangePeriodDateProcessor;
use Statistics\DateProcessors\DateProcessorTypes\GlobalDateProcessors\YearPeriodDateProcessor;

class GlobalDateProcessorDeterminer extends NeededDateProcessorDeterminer
{

    public function getDateProcessorInstance(): DateProcessor|null
    {
        return (match($this->getPeriodTypeRequestValue())
        {
            'day'       => DayPeriodDateProcessor::Singleton($this::$request),
            'month'     => MonthPeriodDateProcessor::Singleton($this::$request),
            'quarter'   => QuarterPeriodDateProcessor::Singleton($this::$request),
            'year'      => YearPeriodDateProcessor::Singleton($this::$request),
            'range'     => RangePeriodDateProcessor::Singleton($this::$request),
            default     => null,
        });
    }
}

<?php

namespace Statistics\DateProcessors\NeededDateProcessorDeterminers;

use Statistics\DateProcessors\DateProcessor;
use Statistics\DateProcessors\DateProcessorTypes\DateGroupedChartDateProcessors\DayPeriodDateProcessor;
use Statistics\DateProcessors\DateProcessorTypes\DateGroupedChartDateProcessors\MonthPeriodDateProcessor;
use Statistics\DateProcessors\DateProcessorTypes\DateGroupedChartDateProcessors\QuarterPeriodDateProcessor;
use Statistics\DateProcessors\DateProcessorTypes\DateGroupedChartDateProcessors\RangePeriodDateProcessor;
use Statistics\DateProcessors\DateProcessorTypes\DateGroupedChartDateProcessors\YearPeriodDateProcessor;

class DateGroupedDateProcessorDeterminer extends NeededDateProcessorDeterminer
{

    protected function getDayPeriodDateProcessor() : DateProcessor
    {
        return DayPeriodDateProcessor::Singleton($this::$request);
    }
    protected function getYearPeriodDateProcessor() : DateProcessor
    {
        return YearPeriodDateProcessor::Singleton($this::$request);
    }
    protected function getQuarterPeriodDateProcessor() : DateProcessor
    {
        return QuarterPeriodDateProcessor::Singleton($this::$request);
    }
    protected function getMonthPeriodDateProcessor() : DateProcessor
    {
        return MonthPeriodDateProcessor::Singleton($this::$request);
    }
    protected function getRangePeriodDateProcessor() : DateProcessor
    {
        /**
         * Range Period 's Convenient DateProcessor is Only That Compatible With The QueryCustomizer instance
         */
        $periodLengthDays = RangePeriodDateProcessor::Singleton($this::$request)->getPeriodLengthByDays();
        return match(true) /** Any Condition Has True Value Will Be Reason To Return THe Convenient Strategy  */
        {
            ($periodLengthDays <= 31)                               =>  $this->getDayPeriodDateProcessor(),
            ($periodLengthDays > 31 && $periodLengthDays <= 124)    => $this->getMonthPeriodDateProcessor(),
            ($periodLengthDays > 124 && $periodLengthDays <= 366)   => $this->getQuarterPeriodDateProcessor(),
            default                                                 => $this->getYearPeriodDateProcessor()
        };
    }

    public function getDateProcessorInstance(): DateProcessor | null
    {
        return (match($this->getPeriodTypeRequestValue())
        {
            'month'                   => $this->getMonthPeriodDateProcessor(),
            'quarter'                 => $this->getQuarterPeriodDateProcessor(),
            'year'                    => $this->getYearPeriodDateProcessor(),
            'range'                   => $this->getRangePeriodDateProcessor(),
            default                   => $this->getDayPeriodDateProcessor(),
        });
    }
}

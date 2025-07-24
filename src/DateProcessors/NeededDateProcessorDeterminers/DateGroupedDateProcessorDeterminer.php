<?php

namespace Statistics\DateProcessors\NeededDateProcessorDeterminers;

use Statistics\DateProcessors\DateProcessor;
use Statistics\DateProcessors\DateProcessorTypes\DateGroupedChartDateProcessors\DayPeriodDateProcessor;
use Statistics\DateProcessors\DateProcessorTypes\DateGroupedChartDateProcessors\MonthPeriodDateProcessor;
use Statistics\DateProcessors\DateProcessorTypes\DateGroupedChartDateProcessors\QuarterPeriodDateProcessor;
use Statistics\DateProcessors\DateProcessorTypes\DateGroupedChartDateProcessors\RangePeriodDateProcessor;
use Statistics\DateProcessors\DateProcessorTypes\DateGroupedChartDateProcessors\SemiAnnaulPeriodDateProcessor;
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

    protected function getRangePeriodLengthDays() : int
    {
        /**
         * Range Period 's Convenient DateProcessor is Only That Compatible With The QueryCustomizer instance
         * @var RangePeriodDateProcessor $rangePeriodDateProcessor
         */
        $rangePeriodDateProcessor = RangePeriodDateProcessor::Singleton($this::$request);
        return  $rangePeriodDateProcessor->getPeriodLengthByDays();
    }

    protected function getRangePeriodDateProcessor() : DateProcessor
    {
        $periodLengthDays = $this->getRangePeriodLengthDays();

        /** Any Condition Has True Value Will Be Reason To Return THe Convenient Strategy  */
        return match(true) 
        {
            ($periodLengthDays <= 31)                               =>  $this->getDayPeriodDateProcessor(),
            ($periodLengthDays > 31 && $periodLengthDays <= 124)    => $this->getMonthPeriodDateProcessor(),
            ($periodLengthDays > 124 && $periodLengthDays <= 366)   => $this->getQuarterPeriodDateProcessor(),
            default                                                 => $this->getYearPeriodDateProcessor()
        };
    }
    
    protected function getSemiAnnualPeriodDateProcessor() : DateProcessor
    {
        return SemiAnnaulPeriodDateProcessor::Singleton($this::$request);
    }

    public function getDateProcessorInstance(): DateProcessor | null
    {
        return (match($this->getPeriodTypeRequestValue())
        {
            'month'                   => $this->getMonthPeriodDateProcessor(),
            'quarter'                 => $this->getQuarterPeriodDateProcessor(),
            'year'                    => $this->getYearPeriodDateProcessor(),
            'range'                   => $this->getRangePeriodDateProcessor(),
            'semi-annual'             => $this->getSemiAnnualPeriodDateProcessor(),
            default                   => $this->getDayPeriodDateProcessor(),
        });
    }
}

<?php

namespace Statistics\DataResources\DBFetcherDataResources\ChartDataResources\DateGroupedChartDataResource\Traits;

use Statistics\DateProcessors\DateProcessorTypes\DateGroupedChartDateProcessors\RangePeriodDateProcessor;
use Statistics\DateProcessors\NeededDateProcessorDeterminers\NeededDateProcessorDeterminer;
use Statistics\QueryCustomizationStrategies\DateGroupedChartQueryCustomizers\DayCountQueryCustomizer;
use Statistics\QueryCustomizationStrategies\DateGroupedChartQueryCustomizers\MonthCountQueryCustomizer;
use Statistics\QueryCustomizationStrategies\DateGroupedChartQueryCustomizers\QuarterCountQueryCustomizer;
use Statistics\QueryCustomizationStrategies\DateGroupedChartQueryCustomizers\YearCountQueryCustomizer;
use Statistics\QueryCustomizationStrategies\QueryCustomizationStrategy;

trait StrategiesDeterminingMethods
{

    protected function getQuarterAggregationOpStrategy() : QueryCustomizationStrategy
    {
        return QuarterCountQueryCustomizer::Singleton( $this->query, $this->currentOperationGroup , $this->currentOperation, $this->dateProcessor);
    }

    protected function getYearAggregationOpStrategy() : QueryCustomizationStrategy
    {
        return YearCountQueryCustomizer::Singleton( $this->query , $this->currentOperationGroup,$this->currentOperation, $this->dateProcessor);
    }

    protected function getMonthAggregationOpStrategy() : QueryCustomizationStrategy
    {
        return MonthCountQueryCustomizer::Singleton(  $this->query , $this->currentOperationGroup,$this->currentOperation, $this->dateProcessor);
    }

    protected function getDayAggregationOpStrategy() : QueryCustomizationStrategy
    {
        return DayCountQueryCustomizer::Singleton( $this->query , $this->currentOperationGroup, $this->currentOperation, $this->dateProcessor);
    }

    protected function getRangeAggregationOpStrategy() : QueryCustomizationStrategy
    {
        $periodLengthDays = RangePeriodDateProcessor::Singleton($this->request)->getPeriodLengthByDays();
        return match(true) /** Any Condition Has True Value Will Be Reason To Return THe Convenient Strategy  */
        {
            ($periodLengthDays <= 31)                               => $this->getDayAggregationOpStrategy(),
            ($periodLengthDays > 31 && $periodLengthDays <= 124)    => $this->getMonthAggregationOpStrategy(),
            ($periodLengthDays > 124 && $periodLengthDays <= 366)   => $this->getQuarterAggregationOpStrategy(),
            default                                                 => $this->getYearAggregationOpStrategy()
        };
    }

    protected function getAggregationOpStrategy() : QueryCustomizationStrategy | null
    {
        return (match(NeededDateProcessorDeterminer::getPeriodTypeRequestValue())
        {
            'month'     => $this->getMonthAggregationOpStrategy(),
            'quarter'   => $this->getQuarterAggregationOpStrategy(),
            'year'      => $this->getYearAggregationOpStrategy(),
            'range'     => $this->getRangeAggregationOpStrategy(),
            default     => $this->getDayAggregationOpStrategy()
        });
    }

}

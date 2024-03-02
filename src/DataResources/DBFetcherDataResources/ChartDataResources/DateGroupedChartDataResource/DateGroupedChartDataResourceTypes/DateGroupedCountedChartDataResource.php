<?php

namespace Statistics\DataResources\DBFetcherDataResources\ChartDataResources\DateGroupedChartDataResource\DateGroupedChartDataResourceTypes;

use Statistics\DataResources\DBFetcherDataResources\ChartDataResources\DateGroupedChartDataResource\DateGroupedChartDataResource;
use Statistics\QueryCustomizationStrategies\DateGroupedChartQueryCustomizers\DateGroupedChartCountQueryCustomizers\DayCountQueryCustomizer;
use Statistics\QueryCustomizationStrategies\DateGroupedChartQueryCustomizers\DateGroupedChartCountQueryCustomizers\MonthCountQueryCustomizer;
use Statistics\QueryCustomizationStrategies\DateGroupedChartQueryCustomizers\DateGroupedChartCountQueryCustomizers\QuarterCountQueryCustomizer;
use Statistics\QueryCustomizationStrategies\DateGroupedChartQueryCustomizers\DateGroupedChartCountQueryCustomizers\YearCountQueryCustomizer;

class DateGroupedCountedChartDataResource extends DateGroupedChartDataResource
{

    protected function getDayAggregationOpStrategyClass(): string
    {
        return DayCountQueryCustomizer::class;
    }

    protected function getMonthAggregationOpStrategyClass(): string
    {
        return MonthCountQueryCustomizer::class;
    }

    protected function getQuarterAggregationOpStrategyClass(): string
    {
        return QuarterCountQueryCustomizer::class;
    }

    protected function getYearAggregationOpStrategyClass(): string
    {
        return YearCountQueryCustomizer::class;
    }
}
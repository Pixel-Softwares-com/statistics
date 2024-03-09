<?php

namespace Statistics\DataResources\DBFetcherDataResources\ChartDataResources\DateGroupedChartDataResource\DateGroupedChartDataResourceTypes;

use Statistics\DataResources\DBFetcherDataResources\ChartDataResources\DateGroupedChartDataResource\DateGroupedChartDataResource;
use Statistics\QueryCustomizationStrategies\DateGroupedChartQueryCustomizers\DateGroupedChartAvgQueryCustomizers\DayAvgQueryCustomizer;
use Statistics\QueryCustomizationStrategies\DateGroupedChartQueryCustomizers\DateGroupedChartAvgQueryCustomizers\MonthAvgQueryCustomizer;
use Statistics\QueryCustomizationStrategies\DateGroupedChartQueryCustomizers\DateGroupedChartAvgQueryCustomizers\QuarterAvgQueryCustomizer;
use Statistics\QueryCustomizationStrategies\DateGroupedChartQueryCustomizers\DateGroupedChartAvgQueryCustomizers\YearAvgQueryCustomizer;

class DateGroupedAvgChartDataResource extends DateGroupedChartDataResource
{
    protected function getDayAggregationOpStrategyClass(): string
    {
        return DayAvgQueryCustomizer::class;
    }

    protected function getMonthAggregationOpStrategyClass(): string
    {
        return MonthAvgQueryCustomizer::class;
    }

    protected function getQuarterAggregationOpStrategyClass(): string
    {
        return QuarterAvgQueryCustomizer::class;
    }

    protected function getYearAggregationOpStrategyClass(): string
    {
        return YearAvgQueryCustomizer::class;
    }
}
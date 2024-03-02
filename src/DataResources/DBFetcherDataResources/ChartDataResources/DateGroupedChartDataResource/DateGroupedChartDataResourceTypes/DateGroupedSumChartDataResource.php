<?php

namespace Statistics\DataResources\DBFetcherDataResources\ChartDataResources\DateGroupedChartDataResource\DateGroupedChartDataResourceTypes;

use Statistics\DataResources\DBFetcherDataResources\ChartDataResources\DateGroupedChartDataResource\DateGroupedChartDataResource;
use Statistics\QueryCustomizationStrategies\DateGroupedChartQueryCustomizers\DateGroupedChartSumQueryCustomizers\DaySumQueryCustomizer;
use Statistics\QueryCustomizationStrategies\DateGroupedChartQueryCustomizers\DateGroupedChartSumQueryCustomizers\MonthSumQueryCustomizer;
use Statistics\QueryCustomizationStrategies\DateGroupedChartQueryCustomizers\DateGroupedChartSumQueryCustomizers\QuarterSumQueryCustomizer;
use Statistics\QueryCustomizationStrategies\DateGroupedChartQueryCustomizers\DateGroupedChartSumQueryCustomizers\YearSumQueryCustomizer;

class DateGroupedSumChartDataResource extends DateGroupedChartDataResource
{
    protected function getDayAggregationOpStrategyClass(): string
    {
        return DaySumQueryCustomizer::class;
    }

    protected function getMonthAggregationOpStrategyClass(): string
    {
        return MonthSumQueryCustomizer::class;
    }

    protected function getQuarterAggregationOpStrategyClass(): string
    {
        return QuarterSumQueryCustomizer::class;
    }

    protected function getYearAggregationOpStrategyClass(): string
    {
        return YearSumQueryCustomizer::class;
    }
}
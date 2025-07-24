<?php

namespace Statistics\DataResources\DBFetcherDataResources\ChartDataResources\DateGroupedChartDataResource;

use Statistics\DataResources\DBFetcherDataResources\DBFetcherDataResource;
use Statistics\DataResources\DBFetcherDataResources\ChartDataResources\DateGroupedChartDataResource\Traits\StrategiesDeterminingMethods;


abstract class DateGroupedChartDataResource extends DBFetcherDataResource
{

    use StrategiesDeterminingMethods ;

    abstract protected function getDayAggregationOpStrategyClass() : string;
    abstract protected function getMonthAggregationOpStrategyClass() : string;
    abstract protected function getQuarterAggregationOpStrategyClass() : string;
    abstract protected function getYearAggregationOpStrategyClass() : string;

}

<?php

namespace Statistics\DataResources\DBFetcherDataResources\ChartDataResources\DateGroupedChartDataResource\DateGroupedChartDataResourceTypes;

use DataResourceInstructors\OperationTypes\AverageOperation;
use DataResourceInstructors\OperationTypes\CountOperation;
use DataResourceInstructors\OperationTypes\SumOperation;
use Exception;
use Statistics\DataResources\DBFetcherDataResources\ChartDataResources\DateGroupedChartDataResource\DateGroupedChartDataResource;
use Statistics\QueryCustomizationStrategies\DateGroupedChartQueryCustomizers\DateGroupedChartAvgQueryCustomizers\DayAvgQueryCustomizer;
use Statistics\QueryCustomizationStrategies\DateGroupedChartQueryCustomizers\DateGroupedChartAvgQueryCustomizers\MonthAvgQueryCustomizer;
use Statistics\QueryCustomizationStrategies\DateGroupedChartQueryCustomizers\DateGroupedChartAvgQueryCustomizers\QuarterAvgQueryCustomizer;
use Statistics\QueryCustomizationStrategies\DateGroupedChartQueryCustomizers\DateGroupedChartAvgQueryCustomizers\YearAvgQueryCustomizer;
use Statistics\QueryCustomizationStrategies\DateGroupedChartQueryCustomizers\DateGroupedChartCountQueryCustomizers\DayCountQueryCustomizer;
use Statistics\QueryCustomizationStrategies\DateGroupedChartQueryCustomizers\DateGroupedChartCountQueryCustomizers\MonthCountQueryCustomizer;
use Statistics\QueryCustomizationStrategies\DateGroupedChartQueryCustomizers\DateGroupedChartCountQueryCustomizers\QuarterCountQueryCustomizer;
use Statistics\QueryCustomizationStrategies\DateGroupedChartQueryCustomizers\DateGroupedChartCountQueryCustomizers\YearCountQueryCustomizer;
use Statistics\QueryCustomizationStrategies\DateGroupedChartQueryCustomizers\DateGroupedChartSumQueryCustomizers\DaySumQueryCustomizer;
use Statistics\QueryCustomizationStrategies\DateGroupedChartQueryCustomizers\DateGroupedChartSumQueryCustomizers\MonthSumQueryCustomizer;
use Statistics\QueryCustomizationStrategies\DateGroupedChartQueryCustomizers\DateGroupedChartSumQueryCustomizers\QuarterSumQueryCustomizer;
use Statistics\QueryCustomizationStrategies\DateGroupedChartQueryCustomizers\DateGroupedChartSumQueryCustomizers\YearSumQueryCustomizer;

class DateGroupedMixChartDataResource extends DateGroupedChartDataResource
{
    /**
     * @throws Exception
     */
    protected function getDayAggregationOpStrategyClass(): string
    {
        $this->failOnNonPassedOperation(); 

        $class = (match($this->currentOperation::getOperationName())
        {
            CountOperation::getOperationName() =>  DayCountQueryCustomizer::class,
            SumOperation::getOperationName() => DaySumQueryCustomizer::class,
            AverageOperation::getOperationName() => DayAvgQueryCustomizer::class  ,
            default => null
        });
        return $class ?? throw $this->getNonDefinedOperationType();
    }

    /**
     * @throws Exception
     */
    protected function getMonthAggregationOpStrategyClass(): string
    {
        $this->failOnNonPassedOperation(); 

        $class = (match($this->currentOperation::getOperationName())
        {
            CountOperation::getOperationName() => MonthCountQueryCustomizer::class,
            SumOperation::getOperationName()   => MonthSumQueryCustomizer::class,
            AverageOperation::getOperationName()   => MonthAvgQueryCustomizer::class ,
            default => null
        });
        return $class ?? throw $this->getNonDefinedOperationType();
    }

    /**
     * @throws Exception
     */
    protected function getQuarterAggregationOpStrategyClass(): string
    {
        $this->failOnNonPassedOperation(); 

        $class = (match($this->currentOperation::getOperationName())
        {
            CountOperation::getOperationName() => QuarterCountQueryCustomizer::class,
            SumOperation::getOperationName()   => QuarterSumQueryCustomizer::class,
            AverageOperation::getOperationName()   => QuarterAvgQueryCustomizer::class ,
            default => null
        });
        return $class ?? throw $this->getNonDefinedOperationType();
    }

    /**
     * @throws Exception
     */
    protected function getYearAggregationOpStrategyClass(): string
    {
        $this->failOnNonPassedOperation(); 
        
        $class = (match($this->currentOperation::getOperationName())
        {
            CountOperation::getOperationName() => YearCountQueryCustomizer::class,
            SumOperation::getOperationName()   => YearSumQueryCustomizer::class,
            AverageOperation::getOperationName()   => YearAvgQueryCustomizer::class ,
            default => null
        });
        return $class ?? throw $this->getNonDefinedOperationType();
    }

    /**
     * @return Exception
     */
    protected function getNonDefinedOperationType() : void
    {
        throw new Exception("A non defined operation type was passed to DateGroupedMixChartDataResource class !");
    }
    
    protected function failOnNonPassedOperation()
    {
        if(!$this->currentOperation) 
        {
             throw $this->getNonPassedOperationType(); 
        }
    }

    /**
     * @return Exception
     */
    protected function getNonPassedOperationType() : Exception
    {
        throw new Exception("There is no operation type was passed to DateGroupedMixChartDataResource class !");
    }
}
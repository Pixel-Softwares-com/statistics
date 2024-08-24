<?php

namespace Statistics\DataResources\DBFetcherDataResources\GlobalDataResource;

use Statistics\DataResources\DBFetcherDataResources\DBFetcherDataResource;
use DataResourceInstructors\OperationTypes\AverageOperation;
use DataResourceInstructors\OperationTypes\CountOperation;
use DataResourceInstructors\OperationTypes\SumOperation;
use Statistics\QueryCustomizationStrategies\QueryCustomizationGlobalStrategies\AverageQueryCustomizer;
use Statistics\QueryCustomizationStrategies\QueryCustomizationGlobalStrategies\CountingQueryCustomizer;
use Statistics\QueryCustomizationStrategies\QueryCustomizationGlobalStrategies\SumQueryCustomizer;
use Statistics\QueryCustomizationStrategies\QueryCustomizationStrategy;

class GlobalDataResource extends DBFetcherDataResource
{

    protected function getAggregationOpStrategy( ) : QueryCustomizationStrategy | null
    {
        return (match($this->currentOperation::getOperationName())
        {
            CountOperation::getOperationName() => CountingQueryCustomizer::Singleton(  $this->query , $this->currentOperationGroup ,$this->currentOperation , $this->dateProcessor),
            SumOperation::getOperationName() => SumQueryCustomizer::Singleton( $this->query,$this->currentOperationGroup ,$this->currentOperation , $this->dateProcessor),
            AverageOperation::getOperationName() => AverageQueryCustomizer::Singleton( $this->query,$this->currentOperationGroup ,$this->currentOperation , $this->dateProcessor),
            default => null
        });
    }

}

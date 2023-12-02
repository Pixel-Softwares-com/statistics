<?php

namespace Statistics\StatisticsProviders\Traits;

use DataResourceInstructors\OperationContainers\OperationGroups\OperationGroup;
use DataResourceInstructors\OperationTypes\AggregationOperation;
use Statistics\StatisticsProviders\StatisticsProviderDecorator;

trait StatisticsProviderOperationsMethods
{

    protected function setAdvancedOperationsPayloadToProcess(array $advancedOperationsPayloadToProcess = [] ) : StatisticsProviderDecorator
    {
        $this->addAdvancedOperations($advancedOperationsPayloadToProcess);
        return $this;
    }
    protected function setOperationsPayloadToProcess(array $operationsPayloadToProcess = []) : StatisticsProviderDecorator
    {
        $this->addOperations($operationsPayloadToProcess);
        return $this;
    }

    /**
     * @param  AggregationOperation $operation
     *
     * There is a need to hold all operations in an array compatible with DataResource's Needs
     * and setting them later to DataResource when (( it is determined )) because it is not determined at this point
     */
    protected function addOperation(string $tableName , AggregationOperation $operation) : StatisticsProviderDecorator
    {
        $this->operationsTempHolder->addOperation($tableName , $operation);
        return $this;
    }
    protected function addOperations( array $operations = []) : StatisticsProviderDecorator
    {
        foreach ($operations as $tableName => $operation)
        {
            if($operation instanceof AggregationOperation)
            {
                $this->addOperation($tableName , $operation);
            }
        }
        return $this;
    }
    /**
     * @param OperationGroup $operationGroup
     *
     * There is a need to hold all operations in an array compatible with DataResource's Needs
     * and setting them later to DataResource when (( it is determined )) because it is not determined at this point
     */
    protected function addAdvancedOperation(OperationGroup $operationGroup) : StatisticsProviderDecorator
    {
        $this->operationsTempHolder->addAdvancedOperation($operationGroup);
        return $this;
    }

    protected function addAdvancedOperations( array $operationGroups = []) : StatisticsProviderDecorator
    {
        foreach ($operationGroups as $operationGroup)
        {
            if($operationGroup instanceof OperationGroup)
            {
                $this->addAdvancedOperation($operationGroup);
            }
        }
        return $this;
    }
}

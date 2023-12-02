<?php

namespace Statistics\OperationsManagement\OperationTempHolders;

use DataResourceInstructors\OperationContainers\OperationGroups\OperationGroup;
use DataResourceInstructors\OperationTypes\AggregationOperation;

class DataResourceOperationsTempHolder extends OperationsTempHolder
{
    protected array $operationGroups = [];

    /**
     * @return array
     */
    public function getOperationGroups(): array
    {
        return $this->operationGroups;
    }

    public function addOperation(string $tableName , AggregationOperation $operation) : OperationsTempHolder
    {
        $this->operationGroups[] = (new OperationGroup($tableName))->addOperation($operation);
        return $this;
    }
    public function addAdvancedOperation(OperationGroup $operationGroup) : OperationsTempHolder
    {
        $this->operationGroups[] = $operationGroup;
        return $this;
    }

}

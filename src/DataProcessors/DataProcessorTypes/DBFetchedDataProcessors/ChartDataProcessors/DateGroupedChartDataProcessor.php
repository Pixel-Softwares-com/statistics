<?php

namespace Statistics\DataProcessors\DataProcessorTypes\DBFetchedDataProcessors\ChartDataProcessors;

use DataResourceInstructors\OperationComponents\Columns\AggregationColumn;
use DataResourceInstructors\OperationContainers\OperationGroups\OperationGroup;
use DataResourceInstructors\OperationTypes\AggregationOperation;
use DataResourceInstructors\OperationTypes\CountOperation;
use Illuminate\Support\Arr;
use Statistics\DataProcessors\DataProcessor;

class DateGroupedChartDataProcessor extends DataProcessor
{
    protected AggregationOperation $currentOperation  ;

    public function setOperationGroup(OperationGroup $operationGroup): DataProcessor
    {
        parent::setOperationGroup($operationGroup);
        $this->setCurrentOperation();
        return $this;
    }

    protected function getCurrentOperationAggColumnColumn() : AggregationColumn
    {
        $columns = $this->currentOperation->getAggregationColumns();
        return Arr::first($columns);
    }

    protected function setCurrentOperation() : DateGroupedChartDataProcessor
    {
        $groupedOperations = $this->operationGroup->getOperations();
        if(empty($groupedOperations))
        {
            $currentOperation = new CountOperation();
        }else{
            $currentOperation = Arr::first($groupedOperations);
        }
        $this->currentOperation = $currentOperation;
        return $this;
    }

    protected function overrideWithDataKeyValuePairs() : void
    {
        $aggColumnAlias = $this->getCurrentOperationAggColumnColumn()->getResultProcessingColumnAlias();
        $dateColumnAlias = $this->operationGroup->getDateColumn()->getResultProcessingColumnAlias();
        foreach ($this->dataToProcess as $row)
        {
            if(!array_key_exists($dateColumnAlias , $row) || !array_key_exists($aggColumnAlias , $row)){continue;}
            $this->processedData[ $row[$dateColumnAlias] ] = $row[$aggColumnAlias];
        }
    }
    protected function setDefaultDateIntervalPairs() : void
    {
        foreach ($this->dateProcessor->getIntervalBetweenDates() as $date)
        {
            $this->processedData[ $date ] = 0;
        }
    }
    protected function processData(): void
    {
        $this->setDefaultDateIntervalPairs();
        $this->overrideWithDataKeyValuePairs();
    }
}

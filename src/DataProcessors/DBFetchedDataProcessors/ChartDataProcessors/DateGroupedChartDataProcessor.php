<?php

namespace Statistics\DataProcessors\DBFetchedDataProcessors\ChartDataProcessors;

use Statistics\DataProcessors\DataProcessor;
use Statistics\DateProcessors\DateProcessor;
use DataResourceInstructors\OperationComponents\Columns\AggregationColumn;
use DataResourceInstructors\OperationContainers\OperationGroups\OperationGroup;
use DataResourceInstructors\OperationTypes\AggregationOperation;
use DataResourceInstructors\OperationTypes\CountOperation;
use Illuminate\Support\Arr;

class DateGroupedChartDataProcessor extends DataProcessor
{
    protected AggregationOperation $countOperation  ;
    public function setInstanceProps(array $dataToProcess, OperationGroup $operationGroup, ?DateProcessor $dateProcessor = null): DataProcessor
    {
        parent::setInstanceProps($dataToProcess, $operationGroup, $dateProcessor);
        return $this->setCurrentOperation();
    }

    protected function getCountedColumn() : AggregationColumn
    {
        $columns = $this->countOperation->getAggregationColumns();
        return Arr::first($columns);
    }

    protected function setCurrentOperation() : DateGroupedChartDataProcessor
    {
        $groupedOperations = $this->operationGroup->getOperations();
        if(empty($groupedOperations))
        {
            $countOperation = new CountOperation();
        }else{
            $countOperation = Arr::first($groupedOperations);
        }
        $this->countOperation = $countOperation;
        return $this;
    }

    protected function overrideWithDataKeyValuePairs() : void
    {
        $countedColumnAlias = $this->getCountedColumn()->getResultProcessingColumnAlias();
        $dateColumnAlias = $this->operationGroup->getDateColumn()->getResultProcessingColumnAlias();
        foreach ($this->dataToProcess as $row)
        {
            if(!array_key_exists($dateColumnAlias , $row) || !array_key_exists($countedColumnAlias , $row)){continue;}
            $this->processedData[ $row[$dateColumnAlias] ] = $row[$countedColumnAlias];
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

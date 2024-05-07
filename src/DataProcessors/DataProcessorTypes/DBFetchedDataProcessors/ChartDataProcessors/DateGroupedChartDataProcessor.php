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

    /**
     * @var array<AggregationOperation>
     */
    protected array $aggregationOperations = [];
    protected array $aggregatedColumnAliases = [];

    public function setOperationGroup(OperationGroup $operationGroup): DataProcessor
    {
        parent::setOperationGroup($operationGroup);
        $this->setAggregationOperations();
        $this->setAggregatedColumnAliases();
        return $this;
    }

    protected function getCurrentOperationAggColumn() : AggregationColumn
    {
        $columns = $this->currentOperation->getAggregationColumns();
        return Arr::first($columns);
    }

//    protected function setCurrentOperation() : DateGroupedChartDataProcessor
//    {
//        $groupedOperations = $this->operationGroup->getOperations();
//        if(empty($groupedOperations))
//        {
//            $currentOperation = new CountOperation();
//        }else{
//            $currentOperation = Arr::first($groupedOperations);
//        }
//        $this->currentOperation = $currentOperation;
//        return $this;
//    }
    protected function setAggregationOperations() : DateGroupedChartDataProcessor
    {
        $groupedOperations = $this->operationGroup->getOperations();
        if(empty($groupedOperations))
        {
            $groupedOperations = [new CountOperation()];
        }
        $this->aggregationOperations = $groupedOperations;
        return $this;
    }
    protected function setAggregatedColumnAliases() : void
    {
        foreach ($this->aggregationOperations as $operation)
        {
            /**
             * @var AggregationColumn $aggregationColumn
             */
            foreach ( $operation->getAggregationColumns() as $aggregationColumn)
            {
                $this->aggregatedColumnAliases[] = $aggregationColumn->getResultProcessingColumnAlias();
            }
        }
    }

    protected function setProcessedKeyValue(array $dataRow , string $dateColumnAlias , string $aggColumnAlias) : void
    {
        $this->processedData[ $dataRow[$dateColumnAlias] ] = $dataRow[$aggColumnAlias] ?? 0;
    }
    protected function overrideWithDataKeyValuePairs() : void
    {
        $aggColumnAlias = $this->getCurrentOperationAggColumn()->getResultProcessingColumnAlias();
        $dateColumnAlias = $this->operationGroup->getDateColumn()->getResultProcessingColumnAlias();
        foreach ($this->dataToProcess as $row)
        {
            Arr::get()
            if(!array_key_exists($dateColumnAlias , $row) || !array_key_exists($aggColumnAlias , $row)){continue;}
            $this->setProcessedKeyValue($row , $dateColumnAlias , $aggColumnAlias);
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

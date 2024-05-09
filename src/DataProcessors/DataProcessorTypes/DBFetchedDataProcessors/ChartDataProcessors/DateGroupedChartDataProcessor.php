<?php

namespace Statistics\DataProcessors\DataProcessorTypes\DBFetchedDataProcessors\ChartDataProcessors;

use DataResourceInstructors\OperationComponents\Columns\AggregationColumn;
use DataResourceInstructors\OperationComponents\Columns\Column;
use DataResourceInstructors\OperationContainers\OperationGroups\OperationGroup;
use DataResourceInstructors\OperationTypes\AggregationOperation;
use Illuminate\Support\Arr;
use Statistics\DataProcessors\DataProcessor;

class DateGroupedChartDataProcessor extends DataProcessor
{
    protected AggregationOperation $currentOperation;

    /**
     * @var array<AggregationOperation>
     */
    protected array $aggregationOperations = [];
    protected array $aggregatedColumns = [];
    protected ?Column $dateColumn = null;

    public function setOperationGroup(OperationGroup $operationGroup): DataProcessor
    {
        parent::setOperationGroup($operationGroup);
        $this->setAggregationOperations();
        $this->setAggregatedColumns();
        $this->setDateColumn();
        return $this;
    }

//    protected function getCurrentOperationAggColumn(): AggregationColumn
//    {
//        $columns = $this->currentOperation->getAggregationColumns();
//        return Arr::first($columns);
//    }

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
    protected function setAggregationOperations(): DateGroupedChartDataProcessor
    {
        $this->aggregationOperations = $this->operationGroup->getOperations();
        return $this;
    }

    protected function initAggregatedColumnsArray() : void
    {
        $this->aggregatedColumns = [];
    }
    protected function setAggregatedColumns(): void
    {
        $this->initAggregatedColumnsArray();
        foreach ( $this->aggregationOperations as $operation)
        {
            $this->aggregatedColumns = array_merge($this->aggregatedColumns ,  $operation->getAggregationColumns() );
        }
    }
    protected function setDateColumn() : void
    {
        $this->dateColumn = $this->operationGroup->getDateColumn();
    }
    protected function getAggregatedColumnValue(array $dataRow , AggregationColumn $column ) : string | int
    {
        return $dataRow[ $column->getResultProcessingColumnAlias() ] ?? 0;
    }

    protected function getDateGroupedAggregatedValues(array $dataRow) : string | int | array
    {
        $values = [];
        /** @var AggregationColumn $column  */
        foreach ($this->aggregatedColumns as $column)
        {
            $values[$column->getResultLabel() ] =  $this->getAggregatedColumnValue($dataRow  , $column)  ;
        }

        if (count($this->aggregatedColumns) == 1)
        {
            return Arr::first( $values);
        }
        return $values;
    }

    protected function getDataRowDateColumnValue(array $dataRow = []) : ?string
    {
        return $dataRow[ $this->dateColumn->getResultProcessingColumnAlias() ] ?? null;
    }
    protected function processDataRow(array $dataRow = []): void
    {
        if ($dateColumnValue = $this->getDataRowDateColumnValue($dataRow))
        {
//            if( array_key_exists($dateColumnValue , $this->processedData) )
//            {
//                $this->processedData[$dateColumnValue] = array_merge($this->processedData[$dateColumnValue] ,  $this->getDateGroupedAggregatedValues($dataRow));
//                return ;
//            }
            $this->processedData[$dateColumnValue] = $this->getDateGroupedAggregatedValues($dataRow);
        }
    }
    protected function overrideWithDataKeyValuePairs() : void
    {
        foreach ($this->dataToProcess as $row)
        {
            $this->processDataRow($row);
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

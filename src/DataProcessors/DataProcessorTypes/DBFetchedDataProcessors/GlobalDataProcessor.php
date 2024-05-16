<?php

namespace Statistics\DataProcessors\DataProcessorTypes\DBFetchedDataProcessors;

use DataResourceInstructors\OperationComponents\Columns\AggregationColumn;
use DataResourceInstructors\OperationTypes\AggregationOperation;
use Illuminate\Support\Str;
use Statistics\DataProcessors\DataProcessingFuncs\RequiredValuesValidators\ColumnRequiredValuesValidator;
use Statistics\DataProcessors\DataProcessingFuncs\RequiredValuesValidators\RequiredValuesValidator;
use Statistics\DataProcessors\DataProcessor;

class GlobalDataProcessor extends DataProcessor
{
    protected RequiredValuesValidator $columnRequiredValuesValidator ;
    protected function initRequiredValuesValidator() : RequiredValuesValidator
    {
        $this->columnRequiredValuesValidator = new ColumnRequiredValuesValidator($this->dataToProcess , $this->operationGroup->getColumnsForProcessingRequiredValues());
        return $this->columnRequiredValuesValidator;
    }
    protected function setProcessedColumnFinalValue(string $aggregationValueLabel , int | array $aggregationValue )
    {
        $this->processedData[$aggregationValueLabel] = $aggregationValue;
    }

    protected function processAggregationOperationColumnLabel(string $columnLabel , array $dataRow = []) : string
    {
        foreach ($this->operationGroup->getSelectingNeededColumnFullNames() as $alias)
        {
            $columnLabel = Str::replace( [":" . $alias , "_"] , [$dataRow[$alias] ?? "" , " "] , $columnLabel );
        }
        return $columnLabel;
    }
    protected function getAggregatingValue(string $aggregationColumnAlias ,array $dataRow = [] ) : int
    {
        return $dataRow[$aggregationColumnAlias] ?? 0;
    }
    protected function processAggregationOperationColumnLabels(AggregationColumn $column ) : void
    {
        $columnAlias = $column->getResultProcessingColumnAlias();
        $columnLabel = $column->getResultLabel();
        foreach ($this->dataToProcess as $row)
        {
            $aggregationValue = $this->getAggregatingValue($columnAlias , $row);
            $aggregationValueLabel = $this->processAggregationOperationColumnLabel($columnLabel , $row);
            $this->setProcessedColumnFinalValue($aggregationValueLabel , $aggregationValue);
        }
    }

    protected function processOperationColumns(AggregationOperation $operation ) : void
    {
        foreach ($operation->getAggregationColumns() as  $column)
        {
            $this->processAggregationOperationColumnLabels($column);
        }
    }

    protected function processOperationsData() : void
    {
        /** @var AggregationOperation $operation */
        foreach ($this->operationGroup->getOperations() as $operation)
        {
            $this->processOperationColumns($operation);
        }
    }
    protected function processMissedData() : void
    {
        $this->dataToProcess = array_merge($this->dataToProcess , $this->initRequiredValuesValidator()->getMissedDataRows() );
    }
    protected function prepareDataToProcess() : void
    {
        $this->processMissedData();
    }

    protected function processData() : void
    {
        $this->prepareDataToProcess();
        $this->processOperationsData();
    }
}

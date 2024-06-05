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

    protected function setProcessedColumnFinalValue(string $aggregationValueLabel , int | array $aggregationValue )
    {
        $this->processedData[$aggregationValueLabel] = $aggregationValue;
    }

    protected function processDynamicColumnLabel(string $columnLabel, array $dataRow = []) : string
    {
        if(Str::contains(":" , $columnLabel))
        {
            foreach ($this->operationGroup->getSelectingNeededColumnFullNames() as $alias)
            {
                $columnLabel = Str::replace( [":" . $alias , "_"] , [$dataRow[$alias] ?? "" , " "] , $columnLabel );
            }
        }
        return $columnLabel;
    }
    protected function isResultLabelOverTheCharLimit(AggregationColumn $column , string $columnProcessedLabel) : bool
    {
        return strlen($columnProcessedLabel) > $column->getResultLabelMaxLength();
    }
    protected function sliceValidResultLabel(string $resultLabelToSlice , AggregationColumn $column ) : string
    {
        return substr( $resultLabelToSlice, 0,    $column->getResultLabelMaxLength()  );
    }
    protected function getColumnResultLabelAltValue(AggregationColumn $column , array $dataRow = []) : string
    {
        $columnAltLabel = $this->processDynamicColumnLabel( $column->getAlternativeShortResultLabel() , $dataRow );
        if($this->isResultLabelOverTheCharLimit($column , $columnAltLabel) )
        {
            return $this->sliceValidResultLabel($columnAltLabel , $column );
        }
        return $columnAltLabel;
    }
    protected function processColumnPrimaryResultLabel(AggregationColumn $column , array $dataRow = []) : string
    {
        $label = $column->getResultLabel() ;
        if(empty($label))
        {
            $label = $column->getResultProcessingColumnAlias();
        }
        return $this->processDynamicColumnLabel($label, $dataRow);
    }
    protected function processAggregationOperationColumnLabel(AggregationColumn $column , array $dataRow = []) : string
    {
        $columnLabel = $this->processColumnPrimaryResultLabel($column , $dataRow);
        if($column->isCharLengthLimited() && $this->isResultLabelOverTheCharLimit($column , $columnLabel) )
        {
            return $this->getColumnResultLabelAltValue($column , $dataRow);
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
        foreach ($this->dataToProcess as $row)
        {
            $aggregationValue = $this->getAggregatingValue($columnAlias , $row);
            $aggregationValueLabel = $this->processAggregationOperationColumnLabel($column , $row);
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
    protected function initRequiredValuesValidator() : RequiredValuesValidator
    {
        $this->columnRequiredValuesValidator = new ColumnRequiredValuesValidator($this->dataToProcess , $this->operationGroup->getColumnsForProcessingRequiredValues());
        return $this->columnRequiredValuesValidator;
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

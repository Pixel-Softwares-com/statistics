<?php

namespace Statistics\QueryCustomizationStrategies\DateGroupedChartQueryCustomizers;

use DataResourceInstructors\OperationComponents\Columns\Column;
use DataResourceInstructors\OperationContainers\OperationGroups\OperationGroup;
use DataResourceInstructors\OperationTypes\AggregationOperation;
use Illuminate\Database\Query\Builder;
use Statistics\DateProcessors\DateProcessor;
use Statistics\QueryCustomizationStrategies\QueryCustomizationStrategy;

abstract class DateGroupedChartQueryCustomizer extends QueryCustomizationStrategy
{

    protected Column $dateColumn;

    /**
     * @param Column $dateColumn
     * @return $this
     */
    public function setDateColumn(Column $dateColumn): DateGroupedChartQueryCustomizer
    {
        $this->dateColumn = $dateColumn;
        return $this;
    }
    protected function setInstanceProps(Builder $query, OperationGroup $currentOperationGroup, ?AggregationOperation $currentOperation = null, ?DateProcessor $dateProcessor = null): QueryCustomizationStrategy
    {
        parent::setInstanceProps(  $query,   $currentOperationGroup,   $currentOperation ,  $dateProcessor );
        return $this->setDateColumn($currentOperationGroup->getDateColumn());
    }

    protected function groupBy() : Builder
    {
        return $this->query->groupByRaw($this->dateColumn->getResultProcessingColumnAlias());
    }

    public function customize(): void
    {
        parent::customize();
        $this->groupBy();
    }


}

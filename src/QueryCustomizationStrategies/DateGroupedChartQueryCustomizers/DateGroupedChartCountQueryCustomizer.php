<?php

namespace Statistics\QueryCustomizationStrategies\DateGroupedChartQueryCustomizers;

use Statistics\DateProcessors\DateProcessor;
use DataResourceInstructors\OperationComponents\Columns\Column;
use DataResourceInstructors\OperationContainers\OperationGroups\OperationGroup;
use DataResourceInstructors\OperationTypes\AggregationOperation;
use Statistics\QueryCustomizationStrategies\QueryCustomizationStrategy;
use Illuminate\Database\Query\Builder;

abstract class DateGroupedChartCountQueryCustomizer extends QueryCustomizationStrategy
{

    protected Column $dateColumn;

    /**
     * @param Column $dateColumn
     * @return $this
     */
    public function setDateColumn(Column $dateColumn): DateGroupedChartCountQueryCustomizer
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

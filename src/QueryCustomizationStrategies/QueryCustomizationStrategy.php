<?php

namespace Statistics\QueryCustomizationStrategies;


use Statistics\DateProcessors\DateProcessor;
use DataResourceInstructors\OperationComponents\Columns\AggregationColumn;
use DataResourceInstructors\OperationContainers\OperationGroups\OperationGroup;
use DataResourceInstructors\OperationTypes\AggregationOperation;
use Statistics\QueryCustomizationStrategies\Traits\SingletonInstanceMethods;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

abstract class QueryCustomizationStrategy
{
    use SingletonInstanceMethods;

    protected Builder $query;
    protected OperationGroup $currentOperationGroup ;
    protected ?DateProcessor $dateProcessor = null;
    protected ?AggregationOperation $currentOperation = null;

    abstract protected function getOperationSqlString(string $column , string $alias) : string;
    /**
     * @param DateProcessor|null $dateProcessor
     * @return QueryCustomizationStrategy
     */
    public function setDateProcessor(?DateProcessor $dateProcessor = null): QueryCustomizationStrategy
    {
        $this->dateProcessor = $dateProcessor;
        return $this;
    }

    protected function addAggregationColumnSql(AggregationColumn $column) : void
    {
        $alias = $column->getResultProcessingColumnAlias();
        $columnName = $column->getColumnFullName();

        $this->query->addSelect(
                                    DB::raw(
                                                $this->getOperationSqlString($columnName , $alias)
                                           )
                                ) ;
    }

    protected function getAggregationColumns() : array
    {
        return $this->currentOperation->getAggregationColumns();
    }

    public function customize(): void
    {
        foreach ($this->getAggregationColumns() as $columnAlias => $columnOb)
        {
            $this->addAggregationColumnSql($columnOb);
        }
    }

    protected function initQueryBuilder(Builder $query )  : QueryCustomizationStrategy
    {
        $this->query = $query;
        return $this;
    }

    /**
     * @param AggregationOperation|null $currentOperation
     * @return $this
     */
    public function setCurrentOperation(?AggregationOperation $currentOperation = null ): QueryCustomizationStrategy
    {
        $this->currentOperation = $currentOperation;
        return $this;
    }

    /**
     * @param ?OperationGroup|null $currentOperationGroup
     * @return $this
     */
    public function setCurrentOperationGroup(?OperationGroup $currentOperationGroup = null  ): QueryCustomizationStrategy
    {
        $this->currentOperationGroup = $currentOperationGroup;
        return $this;
    }


}

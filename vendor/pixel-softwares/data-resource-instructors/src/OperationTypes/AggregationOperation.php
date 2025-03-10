<?php

namespace DataResourceInstructors\OperationTypes;

use DataResourceInstructors\OperationComponents\Columns\AggregationColumn;
use DataResourceInstructors\OperationComponents\Columns\Column;
use DataResourceInstructors\OperationComponents\OperationConditions\AggregationConditions\HavingCondition;
use DataResourceInstructors\OperationComponents\Ordering\OrderingTypes;

abstract class AggregationOperation
{

    protected array $aggregationColumns = [];
    protected array $aggregationConditions = [];
    /**
     * @var array
     * Must Be Like
     * [ "column" => "ordering type constant ]
     */
    protected array $orderingColumns = [];
    protected string $tableName = "";

    abstract static public function getOperationName() : string;

    static public function create() : AggregationOperation
    {
        return new static();
    }

    /**
     * @return array
     */
    public function getAggregationColumns(): array
    {
        return $this->aggregationColumns;
    }

    protected function updateColumnsTableName() : AggregationOperation
    {
        /**
         * @var Column $column
         */
        foreach ($this->aggregationColumns as $column)
        {
            $column->setTableName($this->tableName);
        }
        return $this;
    }
    public function setTableName(string $tableName) : AggregationOperation
    {
        $this->tableName = $tableName;
        return $this->updateColumnsTableName();
    }

    protected function setColumnDefaultResultLabel(AggregationColumn $column  ) : AggregationColumn
    {

        $ColumnResultLabel = $column->getResultLabel();
        if(!$ColumnResultLabel)
        {
            $column->setResultLabel( $column->getResultProcessingColumnAlias());
        }
        return $column;
    }
    public function addAggregationColumn(AggregationColumn $column ) : self
    {
        $this->setColumnDefaultResultLabel($column);
        $this->aggregationColumns[$column->getResultProcessingColumnAlias()] = $column;
        return $this;
    }

    /**
     * @param Column $column
     * @return bool
     */
    protected function IsAggregationColumnSelected(Column $column) : bool
    {
        $columnAlias = $column->getResultProcessingColumnAlias();
        return array_key_exists($columnAlias , $this->aggregationColumns);
    }

    public function whereAggregatedValue(HavingCondition $condition) : AggregationOperation
    {
        $column = $condition->getConditionColumn();
        if($this->IsAggregationColumnSelected($column))
        {
            /**
             * Any Aggregation Column Will Be Used In Having Condition  :
             * Must Be Calculated and Selected Before And Must Have The Same Alias OrWill Be Rejected
             */
            $this->aggregationConditions[] = $condition;
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getAggregationConditions(): array
    {
        return $this->aggregationConditions;
    }

    public function orderBy(AggregationColumn $column , string $orderingStyleConstant = "") : AggregationOperation
    {
        if($this->IsAggregationColumnSelected($column))
        {
            if(!$orderingStyleConstant){$orderingStyleConstant = OrderingTypes::ASC_ORDERING;}
            $this->orderingColumns[$column->getResultProcessingColumnAlias()] = $orderingStyleConstant;
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getOrderingColumns(): array
    {
        return $this->orderingColumns;
    }
}

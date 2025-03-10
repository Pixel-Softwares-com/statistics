<?php

namespace DataResourceInstructors\OperationComponents\OperationConditions;


use DataResourceInstructors\OperationComponents\Columns\Column;

abstract class OperationCondition
{
    protected Column $column ;
    protected mixed $conditionColumnValue ;
    protected string $operator = "=";

    /**
     * @return string
     * Will Return 'and' or 'or' values
     */
    abstract public function getConditionType() : string;

    public function __construct(Column $column  , mixed $value , string $operator = "=")
    {
        $this->column = $column;
        $this->conditionColumnValue = $value ;
        $this->operator = $operator;
    }
    /**
     * @param string $tableName
     * @return $this
     */
    public function setTableName(string $tableName): OperationCondition
    {
        $this->column->setTableName($tableName);
        return $this;
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->column->getTableName();
    }

    /**
     * @return Column
     */
    public function getConditionColumn(): Column
    {
        return $this->column;
    }

    /**
     * @return mixed
     */
    public function getConditionColumnValue(): mixed
    {
        return $this->conditionColumnValue;
    }

    /**
     * @return string
     */
    public function getOperator(): string
    {
        return $this->operator;
    }

}

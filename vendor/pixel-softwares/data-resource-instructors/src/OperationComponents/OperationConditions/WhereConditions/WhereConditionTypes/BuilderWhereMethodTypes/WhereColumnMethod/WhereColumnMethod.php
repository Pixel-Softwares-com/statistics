<?php

namespace DataResourceInstructors\OperationComponents\OperationConditions\WhereConditions\WhereConditionTypes\BuilderWhereMethodTypes\WhereColumnMethod;

use DataResourceInstructors\OperationComponents\Columns\Column;
use DataResourceInstructors\OperationComponents\OperationConditions\WhereConditions\WhereConditionTypes\WhereCondition;
use DataResourceInstructors\OperationComponents\OperationConditions\WhereConditions\WhereConditionTypes\WhereMethod;
use Exception;

abstract class WhereColumnMethod extends WhereMethod
{

    protected static function checkValueType(mixed $value) : void
    {
        if(! $value instanceof Column)
        {
            throw new Exception("condition value must be a Column typed object to use it in WhereColumn method !");
        }
    }
    static public function create(Column $column , mixed $value , string $operator = "=") : WhereCondition
    {
        static::checkValueType($value);
        return parent::create($column , $value , $operator);
    }

    public function __construct(Column $column  , Column $value , string $operator = "=")
    {
        static::checkValueType($value);
        parent::__construct($column , $value , $operator);
    } 
    public function getMethodName(): string
    {
        return "whereColumn";
    }

    public function getMethodParams(): array
    {
        return [
            $this->getConditionColumn()->getColumnFullName() ,
            $this->getOperator() ,
            $this->getConditionColumnValue() ,
            $this->getConditionType() 
        ];
    }
}

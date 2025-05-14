<?php

namespace DataResourceInstructors\OperationComponents\OperationConditions\WhereConditions\WhereConditionTypes\BuilderWhereMethodTypes\WhereInMethod;
 
use Illuminate\Contracts\Support\Arrayable;
use DataResourceInstructors\OperationComponents\Columns\Column;
use DataResourceInstructors\OperationComponents\OperationConditions\WhereConditions\WhereConditionTypes\WhereCondition;
use DataResourceInstructors\OperationComponents\OperationConditions\WhereConditions\WhereConditionTypes\WhereMethod;
use Exception;
use stdClass;

abstract class WhereInMethod extends WhereMethod
{

    protected bool $columnValueNotInArray = false;

    public function MustNotBeIn() : self
    {
        $this->columnValueNotInArray = true;
        return $this;
    }
    public function MustBeIn() : self
    {
        $this->columnValueNotInArray = false;
        return $this;
    }
    public function getMethodName(): string
    {
        return "WhereIn";
    }

    protected static function getValidValueArray(mixed $value)
    {
        if(is_array($value))
        {
            return $value;
        }

        if(!is_object($value))
        {
            return [ $value ];
        }

        if($value instanceof Arrayable)
        {
            return $value->toArray();
        }

        if($value instanceof stdClass)
        {
            return (array) $value;
        }

        throw new Exception("$value must be a valid array to use it in WhereIn Method");
    }

    static public function create(Column $column , mixed $value , string $operator = "=") : WhereCondition
    {
        return parent::create($column , static::getValidValueArray($value) , $operator);
    }

    public function __construct(Column $column  , mixed $value , string $operator = "=")
    {
        parent::__construct($column , static::getValidValueArray($value) , $operator);
    } 
    
    public function getMethodParams(): array
    {
        return [
            $this->getConditionColumn()->getColumnFullName() ,
            $this->getConditionColumnValue() ,
            $this->getConditionType() ,
            $this->columnValueNotInArray
        ];
    }
}

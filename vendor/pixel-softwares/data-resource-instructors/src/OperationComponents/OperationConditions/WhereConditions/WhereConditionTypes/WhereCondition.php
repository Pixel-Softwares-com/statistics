<?php

namespace DataResourceInstructors\OperationComponents\OperationConditions\WhereConditions\WhereConditionTypes;

use DataResourceInstructors\OperationComponents\Columns\Column;
use DataResourceInstructors\OperationComponents\OperationConditions\OperationCondition;

abstract class WhereCondition extends OperationCondition
{
    static public function create(Column $column , mixed $value , string $operator = "=") : WhereCondition
    {
        return new static( $column ,  $value ,  $operator );
    }
}

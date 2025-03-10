<?php

namespace DataResourceInstructors\OperationComponents\OperationConditions\AggregationConditions;

use DataResourceInstructors\OperationComponents\Columns\AggregationColumn;
use DataResourceInstructors\OperationComponents\OperationConditions\OperationCondition;

abstract class HavingCondition extends OperationCondition
{
    static public function create(AggregationColumn $column , mixed $value , string $operator = "=") : HavingCondition
    {
        return new static( $column ,  $value ,  $operator );
    }
    public function __construct(AggregationColumn $column, mixed $value, string $operator = "=")
    {
        parent::__construct($column, $value, $operator);
    }
}

<?php

namespace DataResourceInstructors\OperationComponents\OperationConditions\JoinConditions;

class OnCondition extends JoinCondition
{
    public static function create(string $parentTableName , string $childTableName , string $childForeignKeyName , string $parentLocalKeyName , string $operator = "=") : OnCondition
    {
        return new static($parentTableName ,  $childTableName ,  $childForeignKeyName ,  $parentLocalKeyName ,  $operator);
    }
    public function getConditionType() : string
    {
        return "and";
    }
}

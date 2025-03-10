<?php

namespace DataResourceInstructors\OperationComponents\OperationConditions\JoinConditions;

class OrOnCondition extends JoinCondition
{
    public static function create(string $parentTableName , string $childTableName , string $parentForeignKeyName , string $parentLocalKeyName , string $operator = "=") : OrOnCondition
    {
        return new static($parentTableName ,  $childTableName ,  $parentForeignKeyName ,  $parentLocalKeyName ,  $operator);
    }
    public function getConditionType() : string
    {
        return "or";
    }
}

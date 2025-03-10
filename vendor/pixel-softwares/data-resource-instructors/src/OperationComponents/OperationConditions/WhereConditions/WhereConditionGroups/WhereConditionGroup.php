<?php

namespace DataResourceInstructors\OperationComponents\OperationConditions\WhereConditions\WhereConditionGroups;

use DataResourceInstructors\OperationComponents\OperationConditions\OperationConditionGroup;

abstract class WhereConditionGroup extends OperationConditionGroup
{

    public static function create() : WhereConditionGroup
    {
        return new static();
    }
    /**
     * @return string
     * Will Return 'and' or 'or' values
     */
    abstract public function getConditionGroupType() : string;
}

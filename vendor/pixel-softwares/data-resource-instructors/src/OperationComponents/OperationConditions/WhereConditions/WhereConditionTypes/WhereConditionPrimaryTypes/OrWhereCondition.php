<?php

namespace DataResourceInstructors\OperationComponents\OperationConditions\WhereConditions\WhereConditionTypes\WhereConditionPrimaryTypes;

use DataResourceInstructors\OperationComponents\OperationConditions\WhereConditions\WhereConditionTypes\WhereCondition;

class OrWhereCondition extends WhereCondition
{
    public function getConditionType() : string
    {
        return "or";
    }
}

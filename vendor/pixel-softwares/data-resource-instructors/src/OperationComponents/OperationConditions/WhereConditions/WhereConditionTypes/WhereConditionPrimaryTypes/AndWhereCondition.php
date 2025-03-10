<?php

namespace DataResourceInstructors\OperationComponents\OperationConditions\WhereConditions\WhereConditionTypes\WhereConditionPrimaryTypes;

use DataResourceInstructors\OperationComponents\OperationConditions\WhereConditions\WhereConditionTypes\WhereCondition;

class AndWhereCondition extends WhereCondition
{

    public function getConditionType() : string
    {
        return "and";
    }
}

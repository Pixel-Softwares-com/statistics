<?php

namespace DataResourceInstructors\OperationComponents\OperationConditions\WhereConditions\WhereConditionTypes\BuilderWhereMethodTypes\WhereInMethod;

use DataResourceInstructors\OperationComponents\OperationConditions\WhereConditions\WhereConditionTypes\WhereMethod;

class OrWhereInMethod extends WhereInMethod
{
    public function getConditionType() : string
    {
        return "or";
    }

}

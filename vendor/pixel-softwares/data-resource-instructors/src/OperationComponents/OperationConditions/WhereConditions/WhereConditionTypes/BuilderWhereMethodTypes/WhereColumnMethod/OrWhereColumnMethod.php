<?php

namespace DataResourceInstructors\OperationComponents\OperationConditions\WhereConditions\WhereConditionTypes\BuilderWhereMethodTypes\WhereColumnMethod;
 
class OrWhereColumnMethod extends WhereColumnMethod
{

    public function getConditionType() : string
    {
        return "or";
    }
}

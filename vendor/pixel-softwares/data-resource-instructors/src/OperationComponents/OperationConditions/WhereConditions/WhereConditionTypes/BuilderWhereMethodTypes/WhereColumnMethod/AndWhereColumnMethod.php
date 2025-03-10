<?php

namespace DataResourceInstructors\OperationComponents\OperationConditions\WhereConditions\WhereConditionTypes\BuilderWhereMethodTypes\WhereColumnMethod;
 
class AndWhereColumnMethod extends WhereColumnMethod
{

    public function getConditionType() : string
    {
        return "and";
    }
}

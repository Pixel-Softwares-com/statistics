<?php

namespace DataResourceInstructors\OperationComponents\OperationConditions\WhereConditions\WhereConditionTypes\BuilderWhereMethodTypes\WhereInMethod;


class AndWhereInMethod extends WhereInMethod
{
    public function getConditionType() : string
    {
        return "and";
    }
}

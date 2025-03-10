<?php

namespace DataResourceInstructors\OperationComponents\OperationConditions\WhereConditions\WhereCallbackComponents;

class AndWhereCallbackComponent
{
    public function getConditionGroupType() : string
    {
        return "and";
    } 
}
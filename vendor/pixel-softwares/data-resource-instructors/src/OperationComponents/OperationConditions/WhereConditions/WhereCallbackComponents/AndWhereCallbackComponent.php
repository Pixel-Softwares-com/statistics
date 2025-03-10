<?php

namespace DataResourceInstructors\OperationComponents\OperationConditions\WhereConditions\WhereCallbackComponents;

class AndWhereCallbackComponent extends WhereCallbackComponent
{
    public function getConditionGroupType() : string
    {
        return "and";
    } 
}
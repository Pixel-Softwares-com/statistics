<?php

namespace DataResourceInstructors\OperationComponents\OperationConditions\WhereConditions\WhereCallbackComponents;

class OrWhereCallbackComponent extends WhereCallbackComponent
{
    public function getConditionGroupType() : string
    {
        return "or";
    } 
}
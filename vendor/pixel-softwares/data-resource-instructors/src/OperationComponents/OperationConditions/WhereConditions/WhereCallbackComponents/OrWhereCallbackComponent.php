<?php

namespace DataResourceInstructors\OperationComponents\OperationConditions\WhereConditions\WhereCallbackComponents;

class OrWhereCallbackComponent
{
    public function getConditionGroupType() : string
    {
        return "or";
    } 
}
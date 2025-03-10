<?php

namespace DataResourceInstructors\OperationComponents\OperationConditions\WhereConditions\WhereConditionGroups;


class OrWhereConditionGroup extends WhereConditionGroup
{
    public function getConditionGroupType() : string
    {
        return "or";
    }
}

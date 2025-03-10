<?php

namespace DataResourceInstructors\OperationComponents\OperationConditions\WhereConditions\WhereConditionGroups;


class AndWhereConditionGroup extends WhereConditionGroup
{
    public function getConditionGroupType() : string
    {
        return "and";
    }
}

<?php

namespace DataResourceInstructors\OperationComponents\OperationConditions\AggregationConditions;

class OrHavingCondition extends HavingCondition
{

    public function getConditionType() : string
    {
        return "or";
    }
}

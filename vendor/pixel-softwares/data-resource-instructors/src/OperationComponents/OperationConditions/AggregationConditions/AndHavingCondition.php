<?php

namespace DataResourceInstructors\OperationComponents\OperationConditions\AggregationConditions;

class AndHavingCondition extends HavingCondition
{
    public function getConditionType() : string
    {
        return "and";
    }
}

<?php

namespace DataResourceInstructors\OperationComponents\OperationConditions\WhereConditions\WhereConditionTypes;

abstract class WhereMethod extends WhereCondition
{
    abstract public function getMethodName()  : string;
    abstract public function getMethodParams() : array;
}
<?php

namespace DataResourceInstructors\OperationComponents\OperationConditions;

use DataResourceInstructors\OperationComponents\OperationConditions\WhereConditions\WhereConditionTypes\WhereCondition;

abstract class OperationConditionGroup
{
    protected array $whereConditions = [];


    /**
     * @param string $tableName
     * @return $this
     */
    public function setTableName(string $tableName): OperationConditionGroup
    {
        /** @var WhereCondition $condition */
        foreach ($this->whereConditions as $condition)
        {
            $condition->setTableName($tableName);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getWhereConditions(): array
    {
        return $this->whereConditions;
    }

    public function addWhereCondition(WhereCondition $condition) : OperationConditionGroup
    {
        $this->whereConditions[] = $condition;
        return $this;
    }
}

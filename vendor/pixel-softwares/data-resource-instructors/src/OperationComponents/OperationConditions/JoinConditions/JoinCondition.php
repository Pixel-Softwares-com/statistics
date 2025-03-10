<?php

namespace DataResourceInstructors\OperationComponents\OperationConditions\JoinConditions;

abstract class JoinCondition
{
    protected string $parentTableName ;
    protected string $childTableName ;
    protected string $childForeignKeyName;
    protected string $parentLocalKeyName;
    protected string $operator = "=";

    public function __construct(string $parentTableName , string $childTableName , string $childForeignKeyName , string $parentLocalKeyName , string $operator = "=")
    {
        $this->parentTableName = $parentTableName;
        $this->childTableName = $childTableName;
        $this->childForeignKeyName = $childForeignKeyName;
        $this->parentLocalKeyName = $parentLocalKeyName;
        $this->operator = $operator;
    }

    abstract public function getConditionType() : string;

    /**
     * @return string
     */
    public function getChildTableName(): string
    {
        return $this->childTableName;
    }

    /**
     * @return string
     */
    public function getChildForeignKeyName(): string
    {
        return $this->childForeignKeyName;
    }

    /**
     * @return string
     */
    public function getParentLocalKeyName(): string
    {
        return $this->parentLocalKeyName;
    }

    /**
     * @return string
     */
    public function getParentTableName(): string
    {
        return $this->parentTableName;
    }

    /**
     * @return string
     */
    public function getOperator(): string
    {
        return $this->operator;
    }
    /**
     *
     * These 2 Methods Are The Most Important Methods ... The Rest Of Methods Are Extra Functionality
     * And Maybe Will not Be Used
     */
    public function getParentLocalKeyFullName() : string
    {
        return $this->parentTableName . "." . $this->parentLocalKeyName;
    }
    public function getChildForeignKeyFullName() : string
    {
        return $this->childTableName . "." . $this->childForeignKeyName;
    }
}

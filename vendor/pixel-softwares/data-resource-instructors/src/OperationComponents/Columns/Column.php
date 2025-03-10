<?php

namespace DataResourceInstructors\OperationComponents\Columns;

class Column
{
    protected string $columnName;
    protected string $tableName = "";
    protected string $ResultProcessingColumnAlias = "";

    public function __construct(string $columnName)
    {
        $this->columnName = $columnName;
    }
    static public function create(...$params) : Column
    {
        return new static(...$params);
    }

    public function setResultProcessingColumnDefaultAlias() : Column
    {
        if(!$this->ResultProcessingColumnAlias)
        {
            $this->ResultProcessingColumnAlias = $this->columnName . rand(0 , 1000000) ;
        }
        return $this;
    }
    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }

    /**
     * @param string $tableName
     * @return $this
     */
    public function setTableName(string $tableName): Column
    {
        $this->tableName = $tableName;
        return $this;
    }

    /**
     * @return string
     */
    public function getColumnName(): string
    {
        return $this->columnName;
    }

    public function getColumnFullName() : string
    {
        return $this->tableName . "." . $this->columnName;
    }

    /**
     * @return string
     */
    public function getResultProcessingColumnAlias(): string
    {
        return $this->ResultProcessingColumnAlias;
    }

    /**
     * @param string $alias
     * @return $this
     */
    public function setResultProcessingColumnAlias(string $alias): Column
    {
        $this->ResultProcessingColumnAlias = $alias;
        return $this;
    }

}

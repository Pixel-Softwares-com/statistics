<?php

namespace DataResourceInstructors\OperationContainers\Traits;

use DataResourceInstructors\OperationComponents\Columns\Column;
use DataResourceInstructors\OperationContainers\OperationContainer;


trait HasSelectingNeededColumns
{
    protected array $columns = [];
    protected array $selectingNeededColumns = [];

    /**
     * @param Column $column
     * @return OperationContainer|HasSelectingNeededColumns
     */
    public function addSelectingNeededColumn( Column $column) : self
    {
        $this->columns[] = $column;
        $this->selectingNeededColumns[$column->getColumnFullName()] = $column->getResultProcessingColumnAlias();
        return $this;
    }

    /**
     * @param array $selectingNeededColumns
     * @return HasSelectingNeededColumns|OperationContainer
     */
    public function addSelectingNeededColumns(array $selectingNeededColumns): self
    {
        /** @var Column $column */
        foreach ($selectingNeededColumns as $column)
        {
            if($column instanceof Column)
            {
                $this->addSelectingNeededColumn($column);
            }
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getSelectingNeededColumnFullNames(): array
    {
        return $this->selectingNeededColumns;
    }

    public function getSelectedColumns() : array
    {
        return $this->columns;
    }
}

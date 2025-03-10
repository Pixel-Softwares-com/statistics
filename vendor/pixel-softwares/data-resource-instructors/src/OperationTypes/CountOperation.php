<?php

namespace DataResourceInstructors\OperationTypes;

use DataResourceInstructors\OperationComponents\Columns\AggregationColumn;
use Illuminate\Support\Arr;

class CountOperation extends AggregationOperation
{
    protected function setDefaultAggregationColumn() : void
    {
        if(empty($this->aggregationColumns))
        {
            $defaultColumn = AggregationColumn::create("id")->setResultLabel("Count of rows");
            $this->addAggregationColumn($defaultColumn);
        }
    }

    public function getAggregationColumns(): array
    {
        $this->setDefaultAggregationColumn();
        return parent::getAggregationColumns();
    }

    static public function getOperationName() : string
    {
        return "count";
    }

    public function getFirstCountedColumn() : AggregationColumn
    {
        return Arr::first($this->aggregationColumns);
    }
    /**
     * @return string
     */
    public function getCountedColumnName(): string
    {
        return $this->getFirstCountedColumn()->getColumnFullName();
    }
    /**
     * @return string
     */
    public function getCountedResultLabel(): string
    {
        return $this->getFirstCountedColumn()->getResultLabel();
    }
    /**
     * @return string
     */
    public function getCountedColumnAlias(): string
    {
        return $this->getFirstCountedColumn()->getResultProcessingColumnAlias();
    }

}

<?php

namespace Statistics\OperationsManagement\Operations\CommonOperationFactories;

use DataResourceInstructors\OperationComponents\Columns\AggregationColumn;
use DataResourceInstructors\OperationComponents\Columns\GroupingByColumn;
use DataResourceInstructors\OperationContainers\OperationGroups\OperationGroup;
use DataResourceInstructors\OperationTypes\AggregationOperation;
use DataResourceInstructors\OperationTypes\CountOperation;
use Exception;

class CountingGroupByColumnOperationFactory extends CommonOperationFactory
{
    protected GroupingByColumn $groupingColumn ;

    /**
     * @param GroupingByColumn $column
     */
    public function __construct(GroupingByColumn $column)
    {
        parent::__construct();
        $this->groupBy($column);
    }

    public function groupBy(GroupingByColumn $column) : CountingGroupByColumnOperationFactory
    {
        $this->groupingColumn = $column;
        return $this;
    }

    /**
     * @return string
     * @throws Exception
     */
    protected function processAggregationResultLabel() : string
    {
        $AggregationResultLabel = $this->getAggregationResultLabel() ;
        if(!$AggregationResultLabel){$AggregationResultLabel = ":" . $this->groupingColumn->getResultProcessingColumnAlias() ;}
        return $AggregationResultLabel;
    }

    /**
     * @return AggregationColumn
     * @throws Exception
     */
    protected function initCountedColumn() : AggregationColumn
    {
        $AggregationResultLabel = $this->processAggregationResultLabel();
        return AggregationColumn::create($this->getCountedKeyNameConveniently())->setResultLabel($AggregationResultLabel);
    }
    /**
     * @throws Exception
     */
    protected function prepareCountingOperation() : AggregationOperation
    {
        return CountOperation::create()->addAggregationColumn( $this->initCountedColumn() );
    }
    /**
     * @param string $resultKey
     * @return OperationGroup
     * @throws Exception
     */
    public function make(string $resultKey = ""): OperationGroup
    {
        return OperationGroup::create($this->getTableNameConveniently())
                             ->addOperation( $this->prepareCountingOperation() )
                             ->groupedByColumn($this->groupingColumn)
                             ->enableDateSensitivity($this->getDateColumnConveniently())
                             ->setResultArrayKey($resultKey);
    }
}

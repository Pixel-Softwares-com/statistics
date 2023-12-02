<?php

namespace Statistics\Operations\CommonOperationFactories;

use DataResourceInstructors\OperationComponents\Columns\AggregationColumn;
use DataResourceInstructors\OperationComponents\Columns\GroupingByColumn;
use DataResourceInstructors\OperationContainers\OperationGroups\OperationGroup;
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
     * @param string $resultKey
     * @return OperationGroup
     * @throws Exception
     */
    public function make(string $resultKey = ""): OperationGroup
    {
        $AggregationResultLabel = $this->getAggregationResultLabel() ;
        if(!$AggregationResultLabel){$AggregationResultLabel = ":" . $this->groupingColumn->getResultProcessingColumnAlias() ;}

        $countedKey = AggregationColumn::create($this->getCountedKeyNameConveniently())
                                        ->setResultLabel($AggregationResultLabel);
        $countingOperation = CountOperation::create()->addAggregationColumn($countedKey);

        return OperationGroup::create($this->getTableNameConveniently())
                             ->addOperation($countingOperation)
                             ->groupedByColumn($this->groupingColumn)
                             ->enableDateSensitivity($this->getDateColumnConveniently())
                             ->setResultArrayKey($resultKey);
    }
}

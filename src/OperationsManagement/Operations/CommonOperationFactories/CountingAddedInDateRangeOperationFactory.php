<?php

namespace Statistics\OperationsManagement\Operations\CommonOperationFactories;

use DataResourceInstructors\OperationComponents\Columns\AggregationColumn;
use DataResourceInstructors\OperationContainers\OperationGroups\OperationGroup;
use DataResourceInstructors\OperationTypes\AggregationOperation;
use DataResourceInstructors\OperationTypes\CountOperation;
use Exception;


class CountingAddedInDateRangeOperationFactory extends CommonOperationFactory
{

    /**
     * @return string
     * @throws Exception
     */
    protected function processAggregationResultLabel() : string
    {
        $AggregationResultLabel = $this->getAggregationResultLabel() ;
        if(!$AggregationResultLabel){$AggregationResultLabel = "Added " . $this->getTableTitleConveniently() ;}
        return $AggregationResultLabel;
    }

    /**
     * @return AggregationColumn
     * @throws Exception
     */
    protected function initCountedColumn() : AggregationColumn
    {
        $AggregationResultLabel = $this->processAggregationResultLabel();
        return  AggregationColumn::create($this->getCountedKeyNameConveniently())->setResultLabel( $AggregationResultLabel );
    }
    /**
     * @throws Exception
     */
    protected function prepareCountingOperation() : AggregationOperation
    {
        return  CountOperation::create()->addAggregationColumn( $this->initCountedColumn() );
    }
    /**
     * @param string $resultKey
     * @return OperationGroup
     * @throws Exception
     */
    public function make(string $resultKey = ""): OperationGroup
    {
        return OperationGroup::create( $this->getTableNameConveniently() )
                                ->enableDateSensitivity($this->getDateColumnConveniently())
                                ->addOperation( $this->prepareCountingOperation() )
                                ->setResultArrayKey($resultKey);
    }
}

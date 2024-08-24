<?php

namespace Statistics\OperationsManagement\Operations\CommonOperationFactories;

use DataResourceInstructors\OperationTypes\AggregationOperation;
use Statistics\DateProcessors\DateProcessor;
use Statistics\DateProcessors\DateProcessorTypes\GlobalDateProcessors\GlobalDateProcessor;
use DataResourceInstructors\OperationComponents\Columns\AggregationColumn;
use DataResourceInstructors\OperationComponents\OperationConditions\WhereConditions\WhereConditionTypes\AndWhereCondition;
use DataResourceInstructors\OperationContainers\OperationGroups\OperationGroup;
use DataResourceInstructors\OperationTypes\CountOperation;
use Exception;


class CountingAllRowsUntilEndDateOperationFactory extends CommonOperationFactory
{
    protected ?DateProcessor $dateProcessor  = null;

    /**
     * Only  GlobalDateProcessor Typed DateProcessors Are Accepted
     */
    public function __construct(?GlobalDateProcessor $dateProcessor = null)
    {
        parent::__construct();
        $this->dateProcessor = $dateProcessor;
    }

    protected function setDateCondition(OperationGroup $operationGroup) : void
    {
        if($this->dateProcessor)
        {
            $operationGroup->where( AndWhereCondition::create($this->getDateColumnConveniently() , $this->dateProcessor->getEndingDate() , "<") );
        }
    }

    /**
     * @return string
     * @throws Exception
     */
    protected function processAggregationResultLabel() : string
    {
        $AggregationResultLabel = $this->getAggregationResultLabel() ;
        if(!$AggregationResultLabel){$AggregationResultLabel = "All " . $this->getTableTitleConveniently() ;}
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
        return  CountOperation::create()->addAggregationColumn( $this->initCountedColumn() );
    }
    /**
     * @param string $resultKey
     * @return OperationGroup
     * @throws Exception
     */
    public function make(string $resultKey = ""): OperationGroup
    {
        $operationGroup = OperationGroup::create($this->getTableNameConveniently())
                                        ->addOperation( $this->prepareCountingOperation() )
                                        ->setResultArrayKey($resultKey);
        $this->setDateCondition($operationGroup);
        return $operationGroup;
    }
}

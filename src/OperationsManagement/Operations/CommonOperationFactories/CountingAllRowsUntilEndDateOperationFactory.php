<?php

namespace Statistics\Operations\CommonOperationFactories;

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
     * @param string $resultKey
     * @return OperationGroup
     * @throws Exception
     */
    public function make(string $resultKey = ""): OperationGroup
    {
        $AggregationResultLabel = $this->getAggregationResultLabel() ;
        if(!$AggregationResultLabel){$AggregationResultLabel = "All " . $this->getTableTitleConveniently() ;}

        $countedKey = AggregationColumn::create($this->getCountedKeyNameConveniently())->setResultLabel($AggregationResultLabel);
        $countOperation = CountOperation::create()->addAggregationColumn($countedKey);

        $operationGroup = OperationGroup::create($this->getTableNameConveniently())
                                        ->addOperation($countOperation)
                                        ->setResultArrayKey($resultKey);
        $this->setDateCondition($operationGroup);
        return $operationGroup;
    }
}

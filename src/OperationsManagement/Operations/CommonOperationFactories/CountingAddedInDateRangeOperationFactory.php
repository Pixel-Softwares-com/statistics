<?php

namespace Statistics\Operations\CommonOperationFactories;

use DataResourceInstructors\OperationComponents\Columns\AggregationColumn;
use DataResourceInstructors\OperationContainers\OperationGroups\OperationGroup;
use DataResourceInstructors\OperationTypes\CountOperation;
use Exception;


class CountingAddedInDateRangeOperationFactory extends CommonOperationFactory
{

    /**
     * @param string $resultKey
     * @return OperationGroup
     * @throws Exception
     */
    public function make(string $resultKey = ""): OperationGroup
    {
        $AggregationResultLabel = $this->getAggregationResultLabel() ;
        if(!$AggregationResultLabel){$AggregationResultLabel = "Added " . $this->getTableTitleConveniently() ;}

        $countedKey = AggregationColumn::create($this->getCountedKeyNameConveniently())
                                        ->setResultLabel( $AggregationResultLabel );
        $countOperation = CountOperation::create()->addAggregationColumn($countedKey);

        return OperationGroup::create( $this->getTableNameConveniently() )
                                ->enableDateSensitivity($this->getDateColumnConveniently())
                                ->addOperation($countOperation)
                                ->setResultArrayKey($resultKey);
    }
}

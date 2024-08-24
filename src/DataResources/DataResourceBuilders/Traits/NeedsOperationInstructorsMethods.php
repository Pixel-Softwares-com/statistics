<?php

namespace Statistics\DataResources\DataResourceBuilders\Traits;

use Statistics\DataResources\DataResource;
use Statistics\OperationsManagement\OperationTempHolders\DataResourceOperationsTempHolder;

trait NeedsOperationInstructorsMethods
{
    protected ?DataResourceOperationsTempHolder $operationsTempHolder = null;

    protected function getDefaultOperationTempHolder() : DataResourceOperationsTempHolder
    {
        /** @var DataResource $dataResourceClass  */
        $dataResourceClass = $this->dataResourceClass;
        $defaultOperationTempHolderClass = $dataResourceClass::getAcceptedOperationTempHolderClass();
        return new $defaultOperationTempHolderClass();
    }
    protected function prepareOperationsTempHolder() : void
    {
        if(!$this->getOperationsTempHolder())
        {
            $this->setOperationsTempHolder( $this->getDefaultOperationTempHolder() );
        }
    }
    public function setOperationsTempHolder(DataResourceOperationsTempHolder $operationsTempHolder): void
    {
        $this->operationsTempHolder = $operationsTempHolder;
    }
    public function getOperationsTempHolder(): DataResourceOperationsTempHolder
    {
        return $this->operationsTempHolder;
    }
}
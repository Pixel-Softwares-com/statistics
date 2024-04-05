<?php

namespace Statistics\Interfaces\DataResourceInterfaces\DataResourceBuilderInterfaces;

use Statistics\OperationsManagement\OperationTempHolders\DataResourceOperationsTempHolder;

interface NeedsOperationInstructors
{
    public function setOperationsTempHolder(DataResourceOperationsTempHolder $operationsTempHolder): void;
    public function getOperationsTempHolder(): DataResourceOperationsTempHolder;

}
<?php

namespace Statistics\OperationsManagement\Operations\RelationshipEasyLoaders\OperationGroupRelationshipLoaders;

use DataResourceInstructors\OperationContainers\OperationGroups\OperationGroup;
use Statistics\OperationsManagement\Operations\RelationshipEasyLoaders\RelationshipDescribers\RelationshipDescriber;

class RelationshipColumnsLoader extends OperationGroupRelationshipLoader
{
    public function __construct(OperationGroup $operationGroup , RelationshipDescriber $relationshipDescriber)
    {
        parent::__construct($operationGroup);
        $this->setRelationshipDescriber($relationshipDescriber);
    }


}

<?php

namespace Statistics\OperationsManagement\Operations\RelationshipEasyLoaders\OperationGroupRelationshipLoaders;

use DataResourceInstructors\OperationContainers\OperationGroups\OperationGroup;
use DataResourceInstructors\OperationContainers\RelationshipLoaders\RelationshipLoader;
use Exception;
use Statistics\OperationsManagement\Operations\RelationshipEasyLoaders\RelationshipDescribers\RelationshipDescriber;

abstract class OperationGroupRelationshipLoader
{
    protected OperationGroup $operationGroup;
    protected bool $resultKeyWrapping  = true;

    protected ?RelationshipDescriber $relationshipDescriber = null;
    public function __construct(OperationGroup $operationGroup )
    {
        $this->setOperationGroup($operationGroup);
    }

    /**
     * @param OperationGroup $operationGroup
     * @return $this
     */
    public function setOperationGroup(OperationGroup $operationGroup): self
    {
        $this->operationGroup = $operationGroup;
        return $this;
    }

    /**
     * @return OperationGroup
     */
    public function getOperationGroup(): OperationGroup
    {
        return $this->operationGroup;
    }

    /**
     * @return RelationshipDescriber
     */
    public function getRelationshipDescriber(): RelationshipDescriber
    {
        return $this->relationshipDescriber;
    }
    public function withResultKeyWrapping() : self
    {
        $this->resultKeyWrapping = true;
        return $this;
    }
    public function withoutResultKeyWrapping() : self
    {
        $this->resultKeyWrapping = false;
        return $this;
    }

    /**
     * @param RelationshipDescriber|null $relationshipDescriber
     * @return $this
     */
    public function setRelationshipDescriber(?RelationshipDescriber $relationshipDescriber): self
    {
        $this->relationshipDescriber = $relationshipDescriber;
        return $this;
    }
    protected function getRelationshipKeyName() : string
    {
        return $this->relationshipDescriber->getRelationshipKeyName();
    }
    protected function getRelationshipLoader():RelationshipLoader
    {
        return $this->relationshipDescriber->getRelationshipLoader();
    }
    protected function getStatisticalOperations() : array
    {
        return $this->relationshipDescriber->getStatisticalOperations();
    }

    protected function wrapResultInRelationshipKey() :void
    {
        if($this->resultKeyWrapping)
        {
            $this->operationGroup->setResultArrayKey( $this->getRelationshipKeyName() );
        }
    }
    /**
     * @throws Exception
     */
    protected function checkRelationshipDescriber() : void
    {
        if(!$this->relationshipDescriber)
        {
            throw new Exception("No RelationshipDescriber is set ... No relationship to be loaded");
        }
    }

    /**
     * @throws Exception
     */
    protected function checkLoadingComponents() : void
    {
        $this->checkRelationshipDescriber();
    }

    /**
     * @throws Exception
     */
    public function loadRelationship() : void
    {
        $this->checkLoadingComponents();
        $relationshipLoader = $this->getRelationshipLoader()->setOperations( $this->getStatisticalOperations() );
        $this->operationGroup->loadRelationship($relationshipLoader);
        $this->wrapResultInRelationshipKey();
    }
}

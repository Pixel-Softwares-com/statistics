<?php

namespace Statistics\OperationsManagement\Operations\RelationshipEasyLoaders\OperationGroupRelationshipLoaders;

use Exception;
use Statistics\OperationsManagement\Operations\RelationshipEasyLoaders\FilteredRelationshipDetectors\FilteredRelationshipDetector;

class FilteredRelationshipColumnsLoader extends OperationGroupRelationshipLoader
{

    protected ?string $relationshipFilterKey = null;

    /**
     * @return string|null
     */
    public function getRelationshipFilterKey(): ?string
    {
        return $this->relationshipFilterKey ;
    }

    /**
     * @param string|null $relationshipFilterKey
     * @return $this
     */
    public function useRelationshipFilterKey(?string $relationshipFilterKey ): self
    {
        $this->relationshipFilterKey  = $relationshipFilterKey ;
        return $this;
    }
    protected function initFilteredRelationshipDetector() : FilteredRelationshipDetector
    {
        $detector = new FilteredRelationshipDetector();
        if($this->relationshipFilterKey )
        {
            $detector->useRelationshipFilterKey($this->relationshipFilterKey );
        }
        return $detector;
    }

    /**
     * @throws Exception
     */
    protected function prepareRelationshipDescriber(): void
    {
        /**
         * if it is not set ... it will got from filter ... if also no relationship filter is sent the default RelationshipDescriber will be used
         */
        if(!$this->relationshipDescriber)
        {
            $this->relationshipDescriber = $this->initFilteredRelationshipDetector()->getRelationshipDescriber();
        }
    }
    public function loadRelationship(): void
    {
        $this->prepareRelationshipDescriber();
        parent::loadRelationship();
    }
}

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

    /**
     * @throws Exception
     */
    protected function checkClassType(string $class) : void
    {
        if(!is_subclass_of($class , FilteredRelationshipDetector::class))
        {
            throw new Exception("The provided FilteredRelationshipDetector class is not valid ");
        }
    }
    protected function getFilteredRelationshipDetectorClass() : string
    {
        return FilteredRelationshipDetector::class;
    }

    /**
     * @throws Exception
     */
    protected function initFilteredRelationshipDetector() : FilteredRelationshipDetector
    {
        $detectorClass = $this->getFilteredRelationshipDetectorClass();
        $this->checkClassType($detectorClass);
        $detector = new $detectorClass;
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

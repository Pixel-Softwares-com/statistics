<?php

namespace Statistics\OperationsManagement\Operations\RelationshipEasyLoaders\OperationGroupRelationshipLoaders;

use Exception;
use Statistics\OperationsManagement\Operations\RelationshipEasyLoaders\FilteredRelationshipDetectors\FilteredRelationshipDetector;
use Statistics\OperationsManagement\Operations\RelationshipEasyLoaders\FilteredRelationshipDetectors\Interfaces\DetectsFilteredRelationship;

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
     * @return void
     * @throws Exception
     */
    protected function throwNotValidFilteredRelationshipDetectorClass() : void
    {
        throw new Exception("The provided FilteredRelationshipDetector class is not valid ");
    }
    /**
     * @throws Exception
     */
    protected function checkFilteredRelationshipDetectorType($object) : void
    {
        if(!$object instanceof  DetectsFilteredRelationship )
        {
            $this->throwNotValidFilteredRelationshipDetectorClass();
        }
    }
    protected function getFilteredRelationshipDetectorClass() : string
    {
        return FilteredRelationshipDetector::class;
    }

    /**
     * @throws Exception
     */
    protected function initFilteredRelationshipDetectorObject() : FilteredRelationshipDetector
    {
        $detectorClass = $this->getFilteredRelationshipDetectorClass();
        if(!class_exists($detectorClass))
        {
            $this->throwNotValidFilteredRelationshipDetectorClass();
        }

        $detector = new $detectorClass;
        $this->checkFilteredRelationshipDetectorType($detector);
        return $detector;
    }
    /**
     * @throws Exception
     */
    protected function initFilteredRelationshipDetector() : FilteredRelationshipDetector
    {
        $detector = $this->initFilteredRelationshipDetectorObject();
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

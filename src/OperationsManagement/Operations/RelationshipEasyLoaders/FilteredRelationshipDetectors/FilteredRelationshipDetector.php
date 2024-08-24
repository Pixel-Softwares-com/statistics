<?php

namespace Statistics\OperationsManagement\Operations\RelationshipEasyLoaders\FilteredRelationshipDetectors;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Statistics\OperationsManagement\Operations\RelationshipEasyLoaders\FilteredRelationshipDetectors\Interfaces\DetectsFilteredRelationship;
use Statistics\OperationsManagement\Operations\RelationshipEasyLoaders\RelationshipDescribers\RelationshipDescriber;

class FilteredRelationshipDetector implements DetectsFilteredRelationship
{
    protected string $relationshipFilterKey = "relationship_filter_key";
    protected array $relationshipDescriberClasses = [];
    protected function getRequest() : Request
    {
        return request();
    }
    public function useRelationshipFilterKey(string $relationshipFilterKey):self
    {
        $this->relationshipFilterKey = $relationshipFilterKey;
        return $this;
    }
    public function useRelationshipDescriberClasses(array $relationshipDescriberClasses):self
    {
        $this->relationshipDescriberClasses = $relationshipDescriberClasses;
        return $this;
    }

    protected function getRelationshipDescriberClasses() : array
    {
        return $this->relationshipDescriberClasses;
    }

    protected function getDefaultRelationshipDescriberClass() : string
    {
        return Arr::first( $this->relationshipDescriberClasses );
    }
    protected function getRelationshipFilterValue() : ?string
    {
        return $this->getRequest()->filter[ $this->relationshipFilterKey ] ?? null;
    }
    protected function getFilteredRelationshipDescriberClass() : ?string
    {
        return $this->relationshipDescriberClasses[ $this->getRelationshipFilterValue() ] ?? null;
    }
    protected function getDescriberClass() : string
    {
        return  $this->getFilteredRelationshipDescriberClass()
                ??
                $this->getDefaultRelationshipDescriberClass();
    }
    /**
     * @throws Exception
     */
    protected function checkRelationshipDescriberClasses() : void
    {
        if(empty($this->relationshipDescriberClasses))
        {
            throw new Exception("No relationship describer classes passed to match with relationship request filter value !");
        }
    }
    /**
     * @throws Exception
     */
    public function getRelationshipDescriber() : ?RelationshipDescriber
    {
        $this->checkRelationshipDescriberClasses();
        return RelationshipDescriber::initDescriber( $this->getDescriberClass() );
    }
}

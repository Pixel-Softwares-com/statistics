<?php

namespace Statistics\OperationsManagement\Operations\RelationshipEasyLoaders\FilteredRelationshipDetectors;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Statistics\OperationsManagement\Operations\RelationshipEasyLoaders\RelationshipDescribers\RelationshipDescriber;

class FilteredRelationshipDetector
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
    protected function getDefaultRelationshipDescriberClass() : string
    {
        return Arr::first( $this->relationshipDescriberClasses );
    }
    protected function getRelationshipFilterValue() : ?string
    {
        return $this->getRequest()->filter[ $this->relationshipFilterKey ] ?? null;
    }
    protected function getRelationshipDescriberClasses() : array
    {
        return $this->relationshipDescriberClasses;
    }

    /**
     * @throws Exception
     */
    public function getRelationshipDescriber() : ?RelationshipDescriber
    {
        $relationshipFilterValue = $this->getRelationshipFilterValue();

        $describerClass = $this->relationshipDescriberClasses[$relationshipFilterValue]
                          ??
                          $this->getDefaultRelationshipDescriberClass();
        return RelationshipDescriber::initDescriber($describerClass);
    }
}
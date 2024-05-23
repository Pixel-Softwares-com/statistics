<?php

namespace Statistics\OperationsManagement\Operations\RelationshipEasyLoaders\FilteredRelationshipDetectors;

use DataResourceInstructors\OperationComponents\Columns\AggregationColumn;
use Illuminate\Http\Request;
use Statistics\OperationsManagement\Operations\RelationshipEasyLoaders\RelationshipDescribers\RelationshipDescriber;

class RelationshipFilteredColumnDetector
{
    protected ?RelationshipDescriber $relationshipDescriber = null;
    protected string $columnFilterKeyName = "relationship_column_filter_key";

    public function __construct(RelationshipDescriber $RelationshipDescriber)
    {
        $this->setRelationshipDescriber($RelationshipDescriber);
    }

    /**
     * @param RelationshipDescriber|null $RelationshipDescriber
     */
    public function setRelationshipDescriber(?RelationshipDescriber $RelationshipDescriber): void
    {
        $this->relationshipDescriber = $RelationshipDescriber;
    }
    protected function getRequest() : Request
    {
        return request();
    }
    public function useColumnFilterKeyName(string $columnFilterKeyName):self
    {
        $this->columnFilterKeyName = $columnFilterKeyName;
        return $this;
    }
    protected function getDefaultColumn() : AggregationColumn
    {
        return $this->relationshipDescriber->getFilteringDefaultColumn();
    }
    protected function getFilterValue() : ?string
    {
        return $this->getRequest()->filter[ $this->columnFilterKeyName ] ?? null;
    }
    protected function getRelationshipColumns() : array
    {
        return $this->relationshipDescriber->getRelationshipColumns();
    }
    public function getRelationshipColumn() : ?AggregationColumn
    {
        $relationshipColumns = $this->getRelationshipColumns();
        $columnFilterValue = $this->getFilterValue();

        return $relationshipColumns[ $columnFilterValue ] ?? $this->getDefaultColumn();
    }
}

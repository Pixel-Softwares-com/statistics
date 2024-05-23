<?php

namespace Statistics\OperationsManagement\Operations\RelationshipEasyLoaders\OperationGroupRelationshipLoaders\Traits;

use DataResourceInstructors\OperationComponents\Columns\AggregationColumn;
use DataResourceInstructors\OperationTypes\AggregationOperation;
use Exception;
use Statistics\OperationsManagement\Operations\RelationshipEasyLoaders\FilteredRelationshipDetectors\RelationshipFilteredColumnDetector;

trait RelationshipFilteredColumnMethods
{
    protected ?string $columnFilterKeyName = null;

    /**
     * @throws Exception
     */
    protected function checkRelationshipFilteredColumnDetectorType(string $class) : void
    {
        if(!is_subclass_of($class , RelationshipFilteredColumnDetector::class))
        {
            throw new Exception("The provided RelationshipFilteredColumnDetector class is not valid ");
        }
    }
    protected function getRelationshipFilteredColumnDetectorClass() : string
    {
        return RelationshipFilteredColumnDetector::class;
    }


    /**
     * @throws Exception
     */
    protected function initRelationshipFilteredColumnDetector() : RelationshipFilteredColumnDetector
    {
        $detectorClass = $this->getRelationshipFilteredColumnDetectorClass();
        $this->checkRelationshipFilteredColumnDetectorType($detectorClass);
        $detector = new $detectorClass($this->relationshipDescriber);
        if($this->columnFilterKeyName)
        {
            $detector->useColumnFilterKeyName($this->columnFilterKeyName);
        }
        return $detector;
    }

    /**
     * @param string|null $columnFilterKeyName
     * @return $this
     */
    public function useColumnFilterKeyName(?string $columnFilterKeyName = null): self
    {
        $this->columnFilterKeyName = $columnFilterKeyName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getColumnFilterKeyName(): ?string
    {
        return $this->columnFilterKeyName;
    }

    /**
     * @throws Exception
     */
    protected function getFilteredColumn() : AggregationColumn
    {
        return $this->initRelationshipFilteredColumnDetector()->getRelationshipColumn();
    }

    /**
     * @throws Exception
     */
    protected function getOperation() : AggregationOperation
    {
        return $this->relationshipDescriber->getColumnStatisticalOperation( $this->getFilteredColumn() );
    }

    /**
     * @throws Exception
     */
    protected function getStatisticalOperations(): array
    {
        return [
            $this->getOperation()
        ];
    }

}
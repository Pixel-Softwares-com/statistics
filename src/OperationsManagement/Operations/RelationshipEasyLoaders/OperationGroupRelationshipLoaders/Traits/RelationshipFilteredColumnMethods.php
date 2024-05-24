<?php

namespace Statistics\OperationsManagement\Operations\RelationshipEasyLoaders\OperationGroupRelationshipLoaders\Traits;

use DataResourceInstructors\OperationComponents\Columns\AggregationColumn;
use DataResourceInstructors\OperationTypes\AggregationOperation;
use Exception;
use Statistics\OperationsManagement\Operations\RelationshipEasyLoaders\FilteredRelationshipDetectors\Interfaces\DetectsRelationshipColumn;
use Statistics\OperationsManagement\Operations\RelationshipEasyLoaders\FilteredRelationshipDetectors\RelationshipFilteredColumnDetector;
use Statistics\OperationsManagement\Operations\RelationshipEasyLoaders\OperationGroupRelationshipLoaders\FilteredRelationshipFilteredColumnLoader;
use Statistics\OperationsManagement\Operations\RelationshipEasyLoaders\OperationGroupRelationshipLoaders\RelationshipFilteredColumnLoader;

trait RelationshipFilteredColumnMethods
{
    protected ?string $columnFilterKeyName = null;

    /**
     * @throws Exception
     */
    protected function throwNotValidRelationshipFilteredColumnDetector() : void
    {
        throw new Exception("The provided RelationshipFilteredColumnDetector class is not valid ");
    }
    /**
     * @throws Exception
     */
    protected function checkRelationshipFilteredColumnDetectorType($object) : void
    {
        if(! $object instanceof DetectsRelationshipColumn)
        {
            $this->throwNotValidRelationshipFilteredColumnDetector();
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
        if(!class_exists($detectorClass))
        {
            $this->throwNotValidRelationshipFilteredColumnDetector();
        }

        $detector = new $detectorClass($this->relationshipDescriber);
        $this->checkRelationshipFilteredColumnDetectorType($detector);

        if($this->columnFilterKeyName)
        {
            $detector->useColumnFilterKeyName($this->columnFilterKeyName);
        }
        return $detector;
    }

    /**
     * @param string|null $columnFilterKeyName
     * @return RelationshipFilteredColumnLoader|FilteredRelationshipFilteredColumnLoader|RelationshipFilteredColumnMethods
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

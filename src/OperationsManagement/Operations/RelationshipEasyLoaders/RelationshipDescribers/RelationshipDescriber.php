<?php

namespace Statistics\OperationsManagement\Operations\RelationshipEasyLoaders\RelationshipDescribers;

use DataResourceInstructors\OperationComponents\Columns\AggregationColumn;
use DataResourceInstructors\OperationContainers\RelationshipLoaders\RelationshipLoader;
use DataResourceInstructors\OperationTypes\AggregationOperation;
use DataResourceInstructors\OperationTypes\SumOperation;
use Exception;
use Illuminate\Support\Arr;

abstract class RelationshipDescriber
{

    abstract public function getRelationshipKeyName() : string;
    abstract public function getRelationshipLoader() : RelationshipLoader;

    /**
     * @return array<AggregationColumn>
     * Must return an array of Column object
     */
    abstract public function getRelationshipColumns() : array;

    public function getStatisticalOperations() : array
    {
        return  array_map(function ($column)
                {
                    return $this->getColumnStatisticalOperation($column);
                }, $this->getRelationshipColumns());
    }

    /**
     * @param AggregationColumn $column
     * @return AggregationOperation
     * The default operation is sum operation ... it can be changed from child class
     */
    public function getColumnStatisticalOperation(AggregationColumn $column) : AggregationOperation
    {
        return  SumOperation::create()->addAggregationColumn($column);
    }

    /**
     * @param string|RelationshipDescriber $describerClass
     * @return RelationshipDescriber
     * @throws Exception
     */
    public static function initDescriber(string | RelationshipDescriber $describerClass) : RelationshipDescriber
    {
        if($describerClass instanceof RelationshipDescriber) 
        { 
            return $describerClass;
        }

        if(class_exists($describerClass))
        {
            $describer = new $describerClass;
            return $describer instanceof RelationshipDescriber
                ? $describer
                : throw new Exception("RelationshipDescriber class must be a RelationshipDescriber child type !");
        }
        throw new Exception("Non found a RelationshipDescriber class was used ! ");
    }

    public function getFilteringDefaultColumn() : AggregationColumn
    {
        return Arr::first($this->getRelationshipColumns());
    }
}

<?php

namespace Statistics\QueryCustomizationStrategies\Traits;

use Statistics\DateProcessors\DateProcessor;
use DataResourceInstructors\OperationContainers\OperationGroups\OperationGroup;
use DataResourceInstructors\OperationTypes\AggregationOperation;
use Statistics\QueryCustomizationStrategies\QueryCustomizationStrategy;
//use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder;

trait SingletonInstanceMethods
{
    protected static array $instances = [];

    protected function setInstanceProps(Builder $query  , OperationGroup $currentOperationGroup , ?AggregationOperation $currentOperation = null ,  ?DateProcessor $dateProcessor = null) : QueryCustomizationStrategy
    {
        return $this->initQueryBuilder($query)
                    ->setCurrentOperationGroup($currentOperationGroup)
                    ->setCurrentOperation($currentOperation)
                    ->setDateProcessor($dateProcessor);
    }
    
    protected static function createInstance(Builder $query , OperationGroup $currentOperationGroup , ?AggregationOperation $operation = null , ?DateProcessor $dateProcessor = null): QueryCustomizationStrategy
    {
        return (new static())->setInstanceProps(
                                                    $query  ,
                                                    $currentOperationGroup ,
                                                    $operation ,
                                                    $dateProcessor
                                                );
    }

    final public static function Singleton(Builder $query , OperationGroup $currentOperationGroup , ?AggregationOperation $operation = null , ?DateProcessor $dateProcessor = null) : QueryCustomizationStrategy
    {
        $className = static::class;

        if (!array_key_exists($className , self::$instances))
        {
            return self::$instances[$className] = static::createInstance($query , $currentOperationGroup , $operation , $dateProcessor);
        }
        return self::$instances[$className]->setInstanceProps($query , $currentOperationGroup , $operation , $dateProcessor);
    }


    protected function __construct( )
    {

    }

}

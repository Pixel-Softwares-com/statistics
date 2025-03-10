<?php

namespace DataResourceInstructors\OperationComponents\OperationConditions\WhereConditions\WhereCallbackComponents;

abstract class WhereCallbackComponent
{
    protected $callback;
    protected array $exceptedDataResourceTypes = [];

    public function __construct(callable $callback)
    {
        $this->setCallback($callback);
    }

    public static function create(callable $callback) : self
    {
        return new static($callback);
    }

    abstract public function getConditionGroupType() : string;

    public function setCallback(callable $callback) : void
    {
        $this->callback = $callback;
    }

    public function getCallback() : string
    {
        return $this->callback ;
    }

    public function exceptDataResourceTypes(array $dataResourceTypes) : self
    {
        $this->exceptedDataResourceTypes = $dataResourceTypes;
        return $this;
    }

    public function exceptDataResourceType(string $dataResourceType) : self
    {
        $this->exceptedDataResourceTypes[$dataResourceType] = $dataResourceType;
        return $this; 
    }
    
    public function getExceptedDataResourceTypes() : array
    {
        return $this->exceptedDataResourceTypes;
    }

}
<?php

namespace Statistics\DataResources\DataResourceBuilders;

use ReflectionClass;
use ReflectionException;
use Statistics\DataProcessors\DataProcessor;
use Statistics\DataResources\DataResource;
use Statistics\DataResources\DBFetcherDataResources\GlobalDataResource\GlobalDataResource;
use Statistics\DateProcessors\DateProcessor;
use Statistics\DateProcessors\NeededDateProcessorDeterminers\NeededDateProcessorDeterminer;
use Statistics\Helpers\Helpers;


abstract class DataResourceBuilder
{

    protected string $dateProcessorDeterminerClass = "";
    protected string $dataProcessorClass = "";
    protected string $dataResourceClass = GlobalDataResource::class;
    protected ?DateProcessor $dateProcessor = null;
    protected ?DataResource $dataResource = null;

    /**
     * @throws ReflectionException
     */
    protected function InheritanceOfClassOrFail(string $childClass , string $abstractClass) : void
    {
        $reflection = new ReflectionClass($childClass);
        if(!$reflection->isSubclassOf($abstractClass))
        {
            $exceptionClass = Helpers::getExceptionClass();
            throw new $exceptionClass("The Given  " . $childClass . "  Class Is Not A Valid Inheritance Form  " . $abstractClass . " Class !");
        }
    }

    /**
     * @throws ReflectionException
     */
    protected function checkDateProcessorDeterminerClassType(string $dateProcessorDeterminerClass) : void
    {
        $this->InheritanceOfClassOrFail($dateProcessorDeterminerClass , NeededDateProcessorDeterminer::class);
    }
    /**
     * @param string $dateProcessorDeterminerClass
     * @return $this
     * @throws ReflectionException
     */
    public function useDateProcessorDeterminerClass(string $dateProcessorDeterminerClass) : self
    {
        $this->checkDateProcessorDeterminerClassType($dateProcessorDeterminerClass);
        $this->dateProcessorDeterminerClass = $dateProcessorDeterminerClass;
        return $this;
    }

    /**
     * @throws ReflectionException
     */
    protected function checkDataProcessorClassType(string $dataProcessorClass) : void
    {
        $this->InheritanceOfClassOrFail($dataProcessorClass , DataProcessor::class);
    }
    /**
     * @param string $dataProcessorClass
     * @return $this
     * @throws ReflectionException
     */
    public function useDataProcessorClass(string $dataProcessorClass) : self
    {
        $this->checkDataProcessorClassType($dataProcessorClass);
        $this->dataProcessorClass = $dataProcessorClass;
        return $this;
    }
    protected function initDataResource() : DataResource
    {
        return new $this->dataResourceClass();
    }

    /**
     * @throws ReflectionException
     */
    protected function checkDataResourceClassType(string $dataResourceClass) : void
    {
        $this->InheritanceOfClassOrFail($dataResourceClass , DataResource::class);
    }

    /**
     * @param string $dataResourceClass
     * @return $this
     * @throws ReflectionException
     */
    public function useDataResourceClass(string $dataResourceClass) : self
    {
        $this->checkDataResourceClassType();
        $this->dataResourceClass = $dataResourceClass;
        return $this;
    }

    /**
     * @return DateProcessor|null
     */
    public function getDateProcessor(): ?DateProcessor
    {
        return $this->dateProcessor;
    }
    /**
     * @return string
     */
    public function getDataProcessorClass(): string
    {
        return $this->dataProcessorClass;
    }
    /**
     * @return string
     */
    public function getDateProcessorDeterminerClass(): string
    {
        return $this->dateProcessorDeterminerClass;
    }
    /**
     * @return string
     */
    public function getDataResourceClass(): string
    {
        return $this->dataResourceClass;
    }

    public static function create() : self
    {
        return new static();
    }
    abstract public function getDataResource() : DataResource;
}
<?php

namespace Statistics\StatisticsProviders\Traits;

use CustomGenerators\GeneratorTypes\ValueGenerator;
use Statistics\DataResources\DataResource;
use Statistics\Helpers\Helpers;
use Statistics\Interfaces\StatisticsProvidersInterfaces\HasDefaultAdvancedOperations;
use Statistics\Interfaces\StatisticsProvidersInterfaces\HasDefaultOperations;
use Statistics\Interfaces\StatisticsProvidersInterfaces\NeedsAdditionalAdvancedOperations;
use Statistics\Interfaces\StatisticsProvidersInterfaces\NeedsAdditionalOperations;
use Statistics\OperationsManagement\OperationTempHolders\OperationsTempHolder;
use Statistics\StatisticsProviders\StatisticsProviderDecorator;
use Exception;
use ReflectionClass;
use ReflectionException;

trait DataResourceInitMethods
{

    protected function setDataResourceList(): StatisticsProviderDecorator
    {
        $dataResourceClasses = $this->getDataResourceOrdersByPriorityClasses();
        $this->dataResourcesList = new ValueGenerator($dataResourceClasses);
        return $this;
    }

    protected function appendAdditionalAdvancedOperations(array $advancedOperations = []) : array
    {
        if($this instanceof NeedsAdditionalAdvancedOperations)
        {
            $advancedOperations = array_merge($advancedOperations, $this->getAdditionalAdvancedOperations());
        }
        return $advancedOperations;
    }
    protected function appendAdditionalOperations(array $operations = []) : array
    {
        if($this instanceof NeedsAdditionalOperations)
        {
            $operations = array_merge($operations, $this->getAdditionalOperations());
        }
        return $operations;
    }
    protected function appendDefaultOperations(array $operations = []) : array
    {
        if($this instanceof HasDefaultOperations)
        {
            $operations = array_merge($operations , $this->getDefaultOperations());
        }
        return $operations ;
    }
    protected function appendDefaultAdvancedOperations(array $advancedOperations = []) : array
    {
        if($this instanceof HasDefaultAdvancedOperations)
        {
            $advancedOperations = array_merge($advancedOperations, $this->getDefaultAdvancedOperations());
        }
        return $advancedOperations ;
    }

    protected function setOperationsTempHolderPayload() : void
    {
        $operations = [];
        $advancedOperations = [];

        /** Parent Default Operations & Advanced Operations  */
        $operations = $this->appendDefaultOperations($operations);
        $advancedOperations = $this->appendDefaultAdvancedOperations($advancedOperations);

        /** Child StatisticsProviders Operations & Advanced Operations To Passing to Parent StatisticsProviders */
        $operations = $this->appendAdditionalOperations($operations);
        $advancedOperations = $this->appendAdditionalAdvancedOperations($advancedOperations);

        $this->setAdvancedOperationsPayloadToProcess($advancedOperations )->setOperationsPayloadToProcess( $operations );
    }


    /**
     * @param string $dataResourceClass
     * @return void
     * @throws Exception
     * @throws ReflectionException
     */
    protected function initOperationsTempHolder(string $dataResourceClass ) : void
    {
        $operationTempHolderClass = $dataResourceClass::getAcceptedOperationTempHolderClass();
        $this->InheritanceOfClassOrFail($operationTempHolderClass , OperationsTempHolder::class);
        $this->operationsTempHolder = new $operationTempHolderClass();
        $this->setOperationsTempHolderPayload();
    }

    /**
     * @param string $dataResourceClass
     * @return DataResource|null
     * @throws Exception
     * @throws ReflectionException
     */
    protected function getDataResourceInstance(string $dataResourceClass) : DataResource | null
    {
        $this->initOperationsTempHolder($dataResourceClass);
        return new $dataResourceClass($this->operationsTempHolder , $this->dataProcessor , $this->dateProcessor);
    }
    /**
     * @param string $childClass
     * @param string $abstractClass
     * @return void
     * @throws Exception
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
     * @throws Exception
     * @throws ReflectionException
     */
    protected function setCurrentDataResource() : void
    {
        $dataResourceClass = $this->dataResourcesList->current();
        if($dataResourceClass)
        {
            $this->InheritanceOfClassOrFail($dataResourceClass , DataResource::class);
            $this->dataResource = $this->getDataResourceInstance($dataResourceClass);
            return;
        }
        $this->dataResource = null;
    }

    /**
     * @return void
     * @throws Exception
     * @throws ReflectionException
     */
    protected function setNextDataResource() : void
    {
        $this->dataResourcesList->next();
        $this->setCurrentDataResource();
    }

}

<?php

namespace Statistics\StatisticsProviders\Traits;

use CustomGenerators\GeneratorTypes\ValueGenerator;
use Statistics\DataResources\DataResource;
use Statistics\DataResources\DataResourceBuilders\DataResourceBuilder;
use Statistics\Helpers\Helpers;
use Statistics\Interfaces\DataResourceInterfaces\DataResourceBuilderInterfaces\NeedsOperationInstructors;
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

    protected function setDataResourceBuilderList(): StatisticsProviderDecorator
    {
        $dataResourceClasses = $this->getDataResourceBuildersOrdersByPriorityClasses();
        $this->dataResourcesBuilderList = new ValueGenerator($dataResourceClasses);
        return $this;
    }

    protected function appendAdditionalAdvancedOperations(array $advancedOperations = []) : void
//    array
    {
        if($this instanceof NeedsAdditionalAdvancedOperations)
        {
            $this->addAdvancedOperations( $this->getAdditionalAdvancedOperations() );
//            $advancedOperations = array_merge($advancedOperations, );
        }
//        return $advancedOperations;
    }

    protected function appendAdditionalOperations(array $operations = []) : void
    //array
    {
        if($this instanceof NeedsAdditionalOperations)
        {
            $this->addOperations( $this->getAdditionalOperations() );
//            $operations = array_merge($operations, );
        }
//        return $operations;
    }

    protected function appendDefaultAdvancedOperations(array $advancedOperations = []) : void
    //array
    {
        if($this instanceof HasDefaultAdvancedOperations)
        {
            $this->addAdvancedOperations( $this->getDefaultAdvancedOperations() );
//            $advancedOperations = array_merge($advancedOperations,);
        }
//        return $advancedOperations ;
    }

    protected function appendDefaultOperations(array $operations = []) : void
//    array
    {
        if($this instanceof HasDefaultOperations)
        {
            $this->addOperations( $this->getDefaultOperations() );
//            $operations = array_merge($operations , );
        }
//        return $operations ;
    }

    protected function setOperationsTempHolderPayload() : void
    {
        $operations = [];
        $advancedOperations = [];

        /** Parent Default Operations & Advanced Operations  */
//        $operations =
            $this->appendDefaultOperations($operations);
//        $advancedOperations =
            $this->appendDefaultAdvancedOperations($advancedOperations);

        /** Child step-1-StatisticsProviders Operations & Advanced Operations To Passing to Parent step-1-StatisticsProviders */
//        $operations =
            $this->appendAdditionalOperations($operations);
//        $advancedOperations =
            $this->appendAdditionalAdvancedOperations($advancedOperations);

//        $this->setAdvancedOperationsPayloadToProcess($advancedOperations )->setOperationsPayloadToProcess( $operations );
    }


    /**
     * @param string $dataResourceClass
     * @return void
     * @throws Exception
     * @throws ReflectionException
     */
    protected function initOperationsTempHolder(string $dataResourceClass ) : void
    {
        /** @var DataResource $dataResourceClass  */
        $operationTempHolderClass = $dataResourceClass::getAcceptedOperationTempHolderClass();
        $this->InheritanceOfClassOrFail($operationTempHolderClass , OperationsTempHolder::class);

        $this->operationsTempHolder = new $operationTempHolderClass();
        $this->setOperationsTempHolderPayload();
    }

    /**
     * @throws ReflectionException
     */
    protected function setOperationsTempHolder(DataResourceBuilder | NeedsOperationInstructors $dataResourceBuilder) : void
    {
        $dataResourceClass = $dataResourceBuilder->getDataResourceClass();
        $this->InheritanceOfClassOrFail($dataResourceClass , DataResource::class);

        $this->initOperationsTempHolder( $dataResourceClass );
        $dataResourceBuilder->setOperationsTempHolder( $this->operationsTempHolder );
    }

    /**
     * @throws ReflectionException
     */
    protected function customizeOperationInstructorsNeeds(DataResourceBuilder $dataResourceBuilder) : void
    {
        if($dataResourceBuilder instanceof NeedsOperationInstructors)
        {
            $this->setOperationsTempHolder($dataResourceBuilder);
        }
    }

    /**
     * @throws ReflectionException
     *
     * A hook to customize a DataResourceBuilder object from child StatisticsProvider object
     */
    protected function initDataResourceBuilder(DataResourceBuilder | string $dataResourceBuilderClass = "") : DataResourceBuilder
    {
        if($dataResourceBuilderClass instanceof DataResourceBuilder)
        {
            return $dataResourceBuilderClass;
        }

        $this->InheritanceOfClassOrFail($dataResourceBuilderClass , DataResourceBuilder::class);
        return $dataResourceBuilderClass::Create();
    }
    
    /**
     * @throws Exception
     * @throws ReflectionException
     */
    protected function setCurrentDataResource() : void
    {
        $dataResourceBuilderClass = $this->dataResourcesBuilderList->current();

        if($dataResourceBuilderClass)
        {
            $dataResourceBuilder = $this->initDataResourceBuilder($dataResourceBuilderClass);
            $this->customizeOperationInstructorsNeeds($dataResourceBuilder);
            $this->dataResource = $dataResourceBuilder->getDataResource();
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
        $this->dataResourcesBuilderList->next();
        $this->setCurrentDataResource();
    }

}

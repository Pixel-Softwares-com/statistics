<?php

namespace Statistics\StatisticsProviders;

use Statistics\DataProcessors\DataProcessor;
use Statistics\DataResources\DataResource;
use Statistics\DateProcessors\DateProcessor;
use Statistics\Helpers\Helpers;
use Statistics\OperationsManagement\OperationTempHolders\OperationsTempHolder;
use Statistics\StatisticsProviders\Traits\DataResourceInitMethods;
use Statistics\StatisticsProviders\Traits\StatisticsProviderAbstractMethods;
use Statistics\StatisticsProviders\Traits\StatisticsProviderOperationsMethods;
use Exception;
use CustomGenerators\GeneratorTypes\Generator;
use Illuminate\Database\Eloquent\Model;
use ReflectionException;

abstract class StatisticsProviderDecorator
{
    use StatisticsProviderAbstractMethods , StatisticsProviderOperationsMethods , DataResourceInitMethods;

    protected array $data = [] ;
    protected array $currentStatisticsProviderData = [];
    protected ?Model $model = null;
    protected ?StatisticsProviderDecorator $statisticsProvider = null;
    protected Generator $dataResourcesBuilderList;
    protected ?DataResource $dataResource = null;
    protected DataProcessor $dataProcessor;
    protected ?DateProcessor $dateProcessor = null;
    protected ?OperationsTempHolder $operationsTempHolder = null;

    /**
     * @param string $modelClass
     * @return void
     * @throws Exception
     */
    protected function setValidModel(string $modelClass) : void
    {
        $model = new $modelClass;

        if(!$model instanceof Model)
        {
            $exceptionClass = Helpers::getExceptionClass();
            throw new $exceptionClass("The Given Class " . $modelClass . " Is Not A Model Class");
        }
        $this->model = $model;
    }

//    protected function setDateProcessor() : StatisticsProviderDecorator
//    {
//        $this->dateProcessor = $this->getNeededDateProcessorDeterminerInstance()->getDateProcessorInstance();
//        return $this;
//    }
    /**
     * @return $this
     */
//    public function setDataProcessor(): StatisticsProviderDecorator
//    {
    /**
     * Note : When The StatisticsProvider child classes uses the same type od dataProcessor
     * No Error Or Wrong data will be got ... Because all of needed parameters will be passed
     * from DataResource Object when it needs to process a row of data
     */
//        $this->dataProcessor = $this->getDataProcessorInstance();
//        return $this;
//    }

    /**
     * @param StatisticsProviderDecorator|null $statisticsProvider
     */
    public function __construct( ?StatisticsProviderDecorator $statisticsProvider = null)
    {
        $this->statisticsProvider = $statisticsProvider;
//        $this->setDataProcessor();
//        $this->setDateProcessor();
    }

    protected function mergeCurrentProviderData() : void
    {
        $currentProviderData =  $this->getCurrentStatisticsProviderData();
        $StatisticsTypeName = $this->getStatisticsTypeName();

        if(array_key_exists( $StatisticsTypeName , $this->data ))
        {
            $this->data[ $StatisticsTypeName ] = array_merge( $this->data[ $StatisticsTypeName ] , $currentProviderData );
        }else{
            $this->data[ $StatisticsTypeName ] = $currentProviderData;
        }
    }
    /**
     * @return void
     * @throws ReflectionException
     */
    protected function setCurrentStatisticsProviderData(): void
    {
        $this->currentStatisticsProviderData = $this->getCalculatedStatistics();
    }
    /**
     * @return array
     */
    public function getCurrentStatisticsProviderData(): array
    {
        return $this->currentStatisticsProviderData;
    }

    /**
     * @throws ReflectionException
     */
    protected function prepareDataResources() : void
    {
        $this->setDataResourceBuilderList();
        $this->setCurrentDataResource();
    }
    /**
     * @return $this
     * @throws Exception
     * @throws ReflectionException
     */
    protected function setStatistics()  : StatisticsProviderDecorator
    {
        $this->prepareDataResources();
        if($this->statisticsProvider)
        {
            /**
             * statisticsProvider 's statistics data is already calculated in its constructor , and it is ready to get by getStatistics method
             */
            $this->data = $this->statisticsProvider->getStatistics();
        }

        /**
         * Here ... the statistics presented by child class is still need to calculating , and it will be achieved by  getCalculatedStatistics method
         */
        $this->setCurrentStatisticsProviderData();
        $this->mergeCurrentProviderData();
        return $this;
    }

    protected function getCurrentDataResourceCalculatedStatistics() : array
    {
        return $this->dataResource?->getStatistics() ?? [];
    }

    /**
     * @return array
     * @throws Exception
     * @throws ReflectionException
     */
    protected function getCalculatedStatistics(): array
    {
        $data = $this->getCurrentDataResourceCalculatedStatistics();
        if(empty($data) && $this->dataResource)
        {
            $this->setNextDataResource();
            $data = $this->getCurrentDataResourceCalculatedStatistics();
        }
        return $data;
    }

    /**
     * @return array
     * @throws Exception
     * @throws ReflectionException
     */
    public function getStatistics()  :array
    {
        $this->setStatistics();
        return $this->data;
    }
}

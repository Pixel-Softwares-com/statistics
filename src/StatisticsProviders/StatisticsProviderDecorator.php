<?php

namespace Statistics\StatisticsProviders;

use App\Services\Statistics\DashboardStatistics\DashboardStatisticsProviders\GeneralStatistics\SafeHoursIndexStatisticsProvider\SafeHoursIndexStatisticsProvider;
use Statistics\DataProcessors\DataProcessor;
use Statistics\DataResources\DataResource;
use Statistics\DateProcessors\DateProcessor;
use Statistics\Helpers\Helpers;
use Statistics\Interfaces\StatisticsProvidersInterfaces\ReformulatesStatisticsProviderData;
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

    /**
     * @param StatisticsProviderDecorator|null $statisticsProvider
     */
    public function setStatisticsProvider(?StatisticsProviderDecorator $statisticsProvider = null): self
    {
        $this->statisticsProvider = $statisticsProvider;
        return $this;
    }

    /**
     * @return StatisticsProviderDecorator|null
     */
    public function getStatisticsProvider(): ?StatisticsProviderDecorator
    {
        return $this->statisticsProvider;
    }

    /**
     * @return array
     */
    public function getCurrentStatisticsProviderData(): array
    {
        return $this->currentStatisticsProviderData;
    }
    protected function mergeCurrentProviderData() : void
    {
        $dataToMerge =  $this->getCurrentStatisticsProviderData();
        $StatisticsTypeName = $this->getStatisticsTypeName();

        if(array_key_exists( $StatisticsTypeName , $this->data ))
        {
            $dataToMerge = array_merge( $this->data[ $StatisticsTypeName ] , $dataToMerge );
        }
        $this->data[ $StatisticsTypeName ] = $dataToMerge;
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
     * @return void
     * @throws ReflectionException
     */
    protected function setCurrentStatisticsProviderData(): void
    {
        $this->currentStatisticsProviderData = $this->getCalculatedStatistics();
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

        /**
         * Here ... the statistics presented by child class is still need to calculating , and it will be achieved by  getCalculatedStatistics method
         */
        $this->setCurrentStatisticsProviderData();

        if($this->statisticsProvider)
        {
            /**
             * statisticsProvider 's statistics data is already calculated in its constructor , and it is ready to get by getStatistics method
             */
            $this->data = $this->statisticsProvider->getStatistics();
        }

        $this->mergeCurrentProviderData();
        return $this;
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

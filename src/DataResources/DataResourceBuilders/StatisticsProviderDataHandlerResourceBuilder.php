<?php

namespace Statistics\DataResources\DataResourceBuilders;

use Exception;
use ReflectionException;
use Statistics\DataProcessors\DataProcessorTypes\DBFetchedDataProcessors\GlobalDataProcessor;
use Statistics\DataResources\DataResource;
use Statistics\DataResources\DataResourceBuilders\Traits\DataProcessorSettingMethods;
use Statistics\DataResources\ExistsStatisticalDataHandlerDataResources\StatisticsProviderDataHandlerDataResource;
use Statistics\Interfaces\DataResourceInterfaces\RequiresStatisticsProvider;
use Statistics\StatisticsProviders\StatisticsProviderDecorator;

class StatisticsProviderDataHandlerResourceBuilder extends DataResourceBuilder implements RequiresStatisticsProvider
{
    use DataProcessorSettingMethods;
    protected string $dataProcessorClass = GlobalDataProcessor::class;
    protected string $dataResourceClass = StatisticsProviderDataHandlerDataResource::class;

    protected ?StatisticsProviderDecorator $statisticsProvider = null;

    /**
     * @param StatisticsProviderDecorator $statisticsProvider
     * @return $this
     */
    public function setStatisticsProvider(StatisticsProviderDecorator $statisticsProvider): self
    {
        $this->statisticsProvider = $statisticsProvider;
        return $this;
    }

    /**
     * @throws Exception
     */
    public function getStatisticsProvider(): StatisticsProviderDecorator
    {
        return $this->statisticsProvider;
    }

    /**
     * @throws Exception
     */
    protected function checkStatisticsProvider() : void
    {
        if(!$this->statisticsProvider)
        {
            throw new Exception("No StatisticsProvider Passed to StatisticsProviderDataHandlerResourceBuilder .. It requires to receive a StatisticsProvider instance to work !");
        }
    }

    /**
     * @throws Exception
     */
    protected function initDataResource(): DataResource
    {
        $dataResource = parent::initDataResource();
        $this->checkStatisticsProvider();
        if($dataResource instanceof RequiresStatisticsProvider )
        {
            $dataResource->setStatisticsProvider( $this->getStatisticsProvider() );
        }
        return $dataResource;
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function getDataResource(): DataResource
    {
        return $this->initDataResource()->setDataProcessor($this->initDataProcessor());
    }
}
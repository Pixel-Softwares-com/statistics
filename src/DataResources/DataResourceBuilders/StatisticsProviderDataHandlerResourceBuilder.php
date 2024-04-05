<?php

namespace Statistics\DataResources\DataResourceBuilders;

use ReflectionException;
use Statistics\DataProcessors\DataProcessorTypes\DBFetchedDataProcessors\GlobalDataProcessor;
use Statistics\DataResources\DataResource;
use Statistics\DataResources\DataResourceBuilders\Traits\DataProcessorSettingMethods;
use Statistics\DataResources\ExistsStatisticalDataHandlerDataResources\StatisticsProviderDataHandlerDataResource;
use Statistics\Interfaces\NeedsStatisticsProvider;
use Statistics\StatisticsProviders\StatisticsProviderDecorator;

class StatisticsProviderDataHandlerResourceBuilder extends DataResourceBuilder implements NeedsStatisticsProvider
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
    public function getStatisticsProvider(): StatisticsProviderDecorator
    {
        return $this->statisticsProvider;
    }
    protected function initDataResource(): DataResource
    {
        $dataResource = parent::initDataResource();
        if($dataResource instanceof NeedsStatisticsProvider && $this->statisticsProvider)
        {
            $dataResource->setStatisticsProvider( $this->getStatisticsProvider() );
        }
        return $dataResource;
    }

    /**
     * @throws ReflectionException
     */
    public function getDataResource(): DataResource
    {
        return $this->initDataResource()->setDataProcessor($this->initDataProcessor());
    }
}
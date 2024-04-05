<?php

namespace Statistics\DataResources\DataResourceBuilders;

use Statistics\DataProcessors\DBFetchedDataProcessors\GlobalDataProcessor;
use Statistics\DataResources\DataResource;
use Statistics\DataResources\DataResourceBuilders\Traits\DataProcessorSettingMethods;
use Statistics\Interfaces\NeedsStatisticsProvider;
use Statistics\StatisticsProviders\StatisticsProviderDecorator;

class StatisticsProviderDataHandlerResourceBuilder extends DataResourceBuilder implements NeedsStatisticsProvider
{
    use DataProcessorSettingMethods;
    protected string $dataProcessorClass = GlobalDataProcessor::class;

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

    public function getDataResource(): DataResource
    {
        return $this->initDataResource()->setDataProcessor($this->initDataProcessor());
    }
}
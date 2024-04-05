<?php

namespace Statistics\DataResources\ExistsStatisticalDataHandlerDataResources;

use Statistics\DataResources\DataResource;
use Statistics\Interfaces\NeedsStatisticsProvider;
use Statistics\StatisticsProviders\StatisticsProviderDecorator;

class StatisticsProviderDataHandlerDataResource extends DataResource implements NeedsStatisticsProvider
{
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

    protected function processData(array $data = []) : array
    {
        return $this->dataProcessor?->setDataToProcess($data )->getProcessedData() ?? $data;
    }

    protected function getStatisticsProviderData() : array
    {
        return $this->statisticsProvider?->getCurrentStatisticsProviderData() ?? [];
    }
    protected function setStatistics() : void
    {
        $data = $this->getStatisticsProviderData();
        $this->statistics = $this->processData($data);
    }
}
<?php

namespace Statistics\DataResources\ExistsStatisticalDataHandlerDataResources;

use Exception;
use Statistics\DataResources\DataResource;
use Statistics\Interfaces\RequiresStatisticsProvider;
use Statistics\StatisticsProviders\StatisticsProviderDecorator;

class StatisticsProviderDataHandlerDataResource extends DataResource implements RequiresStatisticsProvider
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

    /**
     * @throws Exception
     */
    public function getStatisticsProvider(): StatisticsProviderDecorator
    {
        if(!$this->statisticsProvider)
        {
            throw new Exception("No StatisticsProvider Passed to StatisticsProviderDataHandlerDataResource .. It requires to receive a StatisticsProvider instance to work !");
        }
        return $this->statisticsProvider;
    }

    protected function processData(array $data = []) : array
    {
        return $this->dataProcessor?->setDataToProcess($data )->getProcessedData() ?? $data;
    }

    /**
     * @throws Exception
     */
    protected function getStatisticsProviderData() : array
    {
        return $this->getStatisticsProvider()->getCurrentStatisticsProviderData() ?? [];
    }

    /**
     * @throws Exception
     */
    protected function setStatistics() : void
    {
        $data = $this->getStatisticsProviderData();
        $this->statistics = $this->processData($data);
    }
}
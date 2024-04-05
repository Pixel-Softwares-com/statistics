<?php

namespace Statistics\StatisticsProviders\StatisticsProviderCommonTypes;

use ReflectionException;
use Statistics\DataProcessors\DBFetchedDataProcessors\GlobalDataProcessor;
use Statistics\DataResources\DataResourceBuilders\DataResourceBuilder;
use Statistics\Interfaces\NeedsStatisticsProvider;
use Statistics\StatisticsProviders\CustomizableStatisticsProvider;
use Statistics\StatisticsProviders\StatisticsProviderDecorator;

abstract class StatisticsProviderDataReProcessorStatisticsProvider extends CustomizableStatisticsProvider implements NeedsStatisticsProvider
{
    protected ?StatisticsProviderDecorator $statisticsProviderToReProcessing = null;

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
    /**
     * @return string
     * Used to allow the child class to override the DataProcessor
     */
    public  static function getDataProcessorClass() : string
    {
        return GlobalDataProcessor::class;
    }

    /**
     * @param DataResourceBuilder|string $dataResourceBuilderClass
     * @return DataResourceBuilder
     * @throws ReflectionException
     */
    protected function initDataResourceBuilder(DataResourceBuilder|string $dataResourceBuilderClass = ""): DataResourceBuilder
    {
        $dataResourceBuilder = parent::initDataResourceBuilder();
        $dataResourceBuilder->useDataProcessorClass( $this->getDataProcessorClass() );
        if($dataResourceBuilder instanceof NeedsStatisticsProvider)
        {
            $dataResourceBuilder->setStatisticsProvider( $this->getStatisticsProvider() );
        }
        return $dataResourceBuilder;
    }
}
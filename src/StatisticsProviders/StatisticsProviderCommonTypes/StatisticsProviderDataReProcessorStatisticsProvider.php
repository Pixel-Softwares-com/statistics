<?php

namespace Statistics\StatisticsProviders\StatisticsProviderCommonTypes;

use ReflectionException;
use Statistics\DataProcessors\DataProcessorTypes\DBFetchedDataProcessors\GlobalDataProcessor;
use Statistics\DataResources\DataResourceBuilders\StatisticsProviderDataHandlerResourceBuilder;
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
        $this->statisticsProviderToReProcessing = $statisticsProvider;
        return $this;
    }
    public function getStatisticsProvider(): StatisticsProviderDecorator
    {
        return $this->statisticsProviderToReProcessing;
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
     * @throws ReflectionException
     */
    protected function getDataResourceBuildersOrdersByPriorityClasses(): array
    {
        return [
            StatisticsProviderDataHandlerResourceBuilder::create()
                ->setStatisticsProvider( $this->getStatisticsProvider() )
                ->useDataProcessorClass( $this->getDataProcessorClass() )
        ];
    }

}
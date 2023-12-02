<?php

namespace Statistics\StatisticsProviders;

use Statistics\DataProcessors\DataProcessor;
use Statistics\DataProcessors\DBFetchedDataProcessors\GlobalDataProcessor;
use Statistics\DataResources\DBFetcherDataResources\GlobalDataResource\GlobalDataResource;
use Statistics\DateProcessors\NeededDateProcessorDeterminers\GlobalDateProcessorDeterminer;
use Statistics\DateProcessors\NeededDateProcessorDeterminers\NeededDateProcessorDeterminer;

/**
 * This Class Is Only To Allow The Programmers to create new and empty types of StatisticsProvider (without default operations)
 * You Can Achieve that by inheritance
 */
abstract class CustomizableStatisticsProvider extends StatisticsProviderDecorator
{
    protected function getDataResourceOrdersByPriorityClasses()  :array
    {
        return [GlobalDataResource::class];
    }
    protected function getDataProcessorInstance(): DataProcessor
    {
        return GlobalDataProcessor::Singleton();
    }
    protected function getNeededDateProcessorDeterminerInstance(): NeededDateProcessorDeterminer
    {
        return GlobalDateProcessorDeterminer::Singleton();
    }
}

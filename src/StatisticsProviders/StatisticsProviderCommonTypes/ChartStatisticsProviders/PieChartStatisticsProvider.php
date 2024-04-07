<?php

namespace Statistics\StatisticsProviders\StatisticsProviderCommonTypes\ChartStatisticsProviders;

use ReflectionException;
use Statistics\DataProcessors\DataProcessorTypes\DBFetchedDataProcessors\ChartDataProcessors\PercentageGroupedChartDataProcessor;
use Statistics\DataResources\DataResourceBuilders\GlobalDataResourceBuilder;
use Statistics\Interfaces\StatisticsProvidersInterfaces\NeedsAdditionalAdvancedOperations;
use Statistics\StatisticsProviders\CustomizableStatisticsProvider;


abstract class PieChartStatisticsProvider extends CustomizableStatisticsProvider implements NeedsAdditionalAdvancedOperations
{

    public function getStatisticsTypeName(): string
    {
        return "pieChart";
    }
    public  static function getDataProcessorClass() : string
    {
        return PercentageGroupedChartDataProcessor::class;
    }

    /**
     * @throws ReflectionException
     */
    protected function getDataResourceBuildersOrdersByPriorityClasses(): array
    {
        return [
            GlobalDataResourceBuilder::create()->useDataProcessorClass( $this->getDataProcessorClass() )
        ];
    }
}

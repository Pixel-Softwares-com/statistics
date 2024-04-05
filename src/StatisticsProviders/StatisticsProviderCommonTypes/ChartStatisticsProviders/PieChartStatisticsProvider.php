<?php

namespace Statistics\StatisticsProviders\StatisticsProviderCommonTypes\ChartStatisticsProviders;

use ReflectionException;
use Statistics\DataProcessors\DataProcessor;
use Statistics\DataProcessors\DBFetchedDataProcessors\ChartDataProcessors\PercentageGroupedChartDataProcessor;
use Statistics\DataProcessors\DBFetchedDataProcessors\GlobalDataProcessor;
use Statistics\DataResources\DataResourceBuilders\GlobalDataResourceBuilder;
use Statistics\Interfaces\StatisticsProvidersInterfaces\NeedsAdditionalAdvancedOperations;
use DataResourceInstructors\OperationComponents\Columns\AggregationColumn;
use DataResourceInstructors\OperationComponents\Columns\Column;
use DataResourceInstructors\OperationComponents\Columns\GroupingByColumn;
use DataResourceInstructors\OperationContainers\OperationGroups\OperationGroup;
use DataResourceInstructors\OperationTypes\CountOperation;
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

//    protected function getDataProcessorInstance(): DataProcessor
//    {
//        return PercentageGroupedChartDataProcessor::Singleton();
//    }
}

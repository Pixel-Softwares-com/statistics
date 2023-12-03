<?php

namespace Statistics\StatisticsProviders\StatisticsProviderCommonTypes\ChartStatisticsProviders;

use Statistics\DataProcessors\DataProcessor;
use Statistics\DataProcessors\DBFetchedDataProcessors\ChartDataProcessors\PercentageGroupedChartDataProcessor;
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

    protected function getDataProcessorInstance(): DataProcessor
    {
        return PercentageGroupedChartDataProcessor::Singleton();
    }
}

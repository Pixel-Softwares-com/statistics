<?php

namespace Statistics\StatisticsProviders\StatisticsProviderCommonTypes\ChartStatisticsProviders;

use Statistics\DataProcessors\DataProcessor;
use Statistics\DataProcessors\DBFetchedDataProcessors\ChartDataProcessors\DateGroupedChartDataProcessor;
use Statistics\DataResources\DBFetcherDataResources\ChartDataResources\DateGroupedChartDataResource\DateGroupedChartDataResource;
use Statistics\DateProcessors\NeededDateProcessorDeterminers\DateGroupedDateProcessorDeterminer;
use Statistics\DateProcessors\NeededDateProcessorDeterminers\NeededDateProcessorDeterminer;
use Statistics\Interfaces\StatisticsProvidersInterfaces\HasDefaultAdvancedOperations;
use Statistics\Interfaces\StatisticsProvidersInterfaces\NeedsStatisticsProviderModelClass;
use DataResourceInstructors\OperationComponents\Columns\AggregationColumn;
use DataResourceInstructors\OperationComponents\Columns\Column;
use DataResourceInstructors\OperationContainers\OperationGroups\OperationGroup;
use DataResourceInstructors\OperationTypes\CountOperation;
use Statistics\StatisticsProviders\StatisticsProviderDecorator;


abstract class BarChartStatisticsProvider extends StatisticsProviderDecorator implements HasDefaultAdvancedOperations , NeedsStatisticsProviderModelClass
{
    public function __construct(?StatisticsProviderDecorator $statisticsProvider = null)
    {
        $this->setValidModel($this->getStatisticsProviderModelClass());
        parent::__construct($statisticsProvider);
    }

    public function getStatisticsTypeName(): string
    {
        return "barChart";
    }
    protected function getDataResourceOrdersByPriorityClasses()  :array
    {
        return [DateGroupedChartDataResource::class];
    }

    protected function getDataProcessorInstance(): DataProcessor
    {
        return DateGroupedChartDataProcessor::Singleton();
    }

    protected function getNeededDateProcessorDeterminerInstance(): NeededDateProcessorDeterminer
    {
        return DateGroupedDateProcessorDeterminer::Singleton();
    }

    protected function getDateGroupedRowsCount() : OperationGroup
    {
        $dateColumn = Column::create($this->model->getStatisticDateColumnName())
                            ->setResultProcessingColumnAlias("DateColumn");

        $idColumn = AggregationColumn::create($this->model->getKeyName());
        $countingOp = CountOperation::create()->addAggregationColumn($idColumn);

        return OperationGroup::create($this->model->getTable())
                             ->enableDateSensitivity($dateColumn)
                             ->addOperation($countingOp);
    }

    public function getDefaultAdvancedOperations() : array
    {
        return [
            $this->getDateGroupedRowsCount()
        ];
    }

}

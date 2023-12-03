<?php

namespace Statistics\StatisticsProviders\StatisticsProviderCommonTypes\ChartStatisticsProviders;

use Statistics\DataProcessors\DataProcessor;
use Statistics\DataProcessors\DBFetchedDataProcessors\ChartDataProcessors\DateGroupedChartDataProcessor;
use Statistics\DataResources\DBFetcherDataResources\ChartDataResources\DateGroupedChartDataResource\DateGroupedChartDataResource;
use Statistics\DateProcessors\NeededDateProcessorDeterminers\DateGroupedDateProcessorDeterminer;
use Statistics\DateProcessors\NeededDateProcessorDeterminers\NeededDateProcessorDeterminer;
use Statistics\Interfaces\StatisticsProvidersInterfaces\HasDefaultAdvancedOperations;
use Statistics\Interfaces\StatisticsProvidersInterfaces\NeedsModelClass;
use DataResourceInstructors\OperationComponents\Columns\AggregationColumn;
use DataResourceInstructors\OperationComponents\Columns\Column;
use DataResourceInstructors\OperationContainers\OperationGroups\OperationGroup;
use DataResourceInstructors\OperationTypes\CountOperation;
use Statistics\StatisticsProviders\StatisticsProviderDecorator;
use Statistics\Interfaces\ModelInterfaces\StatisticsProviderModel;


abstract class BarChartStatisticsProvider extends StatisticsProviderDecorator implements HasDefaultAdvancedOperations , NeedsModelClass
{
    public function __construct(?StatisticsProviderDecorator $statisticsProvider = null)
    {
        $this->setValidModel($this->getModelClass());
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

    protected function getDateColumnDefaultName() : string
    {
        return "created_at";
    }
    protected function getDateColumnName() : string
    {
        if($this->model instanceof StatisticsProviderModel)
        {
            return $this->model->getStatisticDateColumnName();
        }
        return $this->getDateColumnDefaultName();
    }

    protected function getDateColumn() : Column
    {
        return Column::create( $this->getDateColumnName() )->setResultProcessingColumnAlias("DateColumn");
    }

    protected function getDateGroupedRowsCount() : OperationGroup
    {
        $dateColumn = $this->getDateColumn();

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

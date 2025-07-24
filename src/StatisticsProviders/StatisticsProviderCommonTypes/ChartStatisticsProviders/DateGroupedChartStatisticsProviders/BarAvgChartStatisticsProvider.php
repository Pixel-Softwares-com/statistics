<?php

namespace Statistics\StatisticsProviders\StatisticsProviderCommonTypes\ChartStatisticsProviders\DateGroupedChartStatisticsProviders;

use DataResourceInstructors\OperationComponents\Columns\AggregationColumn;
use DataResourceInstructors\OperationComponents\Columns\Column;
use DataResourceInstructors\OperationContainers\OperationGroups\OperationGroup;
use DataResourceInstructors\OperationTypes\AggregationOperation;
use DataResourceInstructors\OperationTypes\AverageOperation;
use ReflectionException;
use Statistics\DataResources\DataResourceBuilders\DateGroupedChartDataResourceBuilder;
use Statistics\DataResources\DBFetcherDataResources\ChartDataResources\DateGroupedChartDataResource\DateGroupedChartDataResourceTypes\DateGroupedAvgChartDataResource;
use Statistics\Interfaces\ModelInterfaces\StatisticsProviderModel;
use Statistics\Interfaces\StatisticsProvidersInterfaces\HasDefaultAdvancedOperations;
use Statistics\Interfaces\StatisticsProvidersInterfaces\NeedsModelClass;
use Statistics\StatisticsProviders\StatisticsProviderDecorator;


abstract class BarAvgChartStatisticsProvider extends StatisticsProviderDecorator implements HasDefaultAdvancedOperations , NeedsModelClass
{
    public function __construct(?StatisticsProviderDecorator $statisticsProvider = null)
    {
        $this->setValidModel($this->getModelClass());
    }

    /**
     * @throws ReflectionException
     */
    protected function getDataResourceBuildersOrdersByPriorityClasses(): array
    {
        return [
            DateGroupedChartDataResourceBuilder::create()->useDataResourceClass(DateGroupedAvgChartDataResource::class)
        ];
    }
    /**
     * @return AggregationColumn
     * Array of AggregationColumn objects
     */
    abstract protected function getAvgColumn() : AggregationColumn;

    public function getStatisticsTypeName(): string
    {
        return "barAvgChart";
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
        return Column::create( $this->getDateColumnName() )
                     ->setResultProcessingColumnAlias("DateColumn");
    }

    protected function getAvgOperation() : AggregationOperation
    {
        return AverageOperation::create()->addAggregationColumn( $this->getAvgColumn() );
    }

    protected function getAvgOperationGroup() : OperationGroup
    {
        $dateColumn = $this->getDateColumn();
        
        return OperationGroup::create($this->model->getTable())
                             ->enableDateSensitivity($dateColumn)
                             ->addOperation( $this->getAvgOperation() );
    }

    public function getDefaultAdvancedOperations() : array
    {
        return [
            $this->getAvgOperationGroup()
        ];
    }

}

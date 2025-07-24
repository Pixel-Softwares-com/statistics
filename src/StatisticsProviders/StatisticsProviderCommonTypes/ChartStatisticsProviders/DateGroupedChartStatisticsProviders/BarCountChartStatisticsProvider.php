<?php

namespace Statistics\StatisticsProviders\StatisticsProviderCommonTypes\ChartStatisticsProviders\DateGroupedChartStatisticsProviders;

use DataResourceInstructors\OperationComponents\Columns\AggregationColumn;
use DataResourceInstructors\OperationComponents\Columns\Column;
use DataResourceInstructors\OperationContainers\OperationGroups\OperationGroup;
use DataResourceInstructors\OperationTypes\AggregationOperation;
use DataResourceInstructors\OperationTypes\CountOperation;
use Exception;
use ReflectionException;
use Statistics\DataResources\DataResourceBuilders\DateGroupedChartDataResourceBuilder;
use Statistics\DataResources\DBFetcherDataResources\ChartDataResources\DateGroupedChartDataResource\DateGroupedChartDataResourceTypes\DateGroupedCountChartDataResource;
use Statistics\Interfaces\ModelInterfaces\StatisticsProviderModel;
use Statistics\Interfaces\StatisticsProvidersInterfaces\HasDefaultAdvancedOperations;
use Statistics\Interfaces\StatisticsProvidersInterfaces\NeedsModelClass;
use Statistics\StatisticsProviders\StatisticsProviderDecorator;


abstract class BarCountChartStatisticsProvider extends StatisticsProviderDecorator implements HasDefaultAdvancedOperations , NeedsModelClass
{
    /**
     * @throws Exception
     */
    public function __construct(?StatisticsProviderDecorator $statisticsProvider = null)
    {
        $this->setValidModel($this->getModelClass());
    }

    public function getStatisticsTypeName(): string
    {
        return "barChart";
    }

    /**
     * @throws ReflectionException
     */
    protected function getDataResourceBuildersOrdersByPriorityClasses(): array
    {
        return [
            DateGroupedChartDataResourceBuilder::create()->useDataResourceClass(DateGroupedCountChartDataResource::class)
        ];
    }

    protected function getOperationGroupTableName() : string
    {
        return $this->model->getTable();
    }

    protected function getPrimaryKeyColumn() : AggregationColumn
    {
        return AggregationColumn::create($this->model->getKeyName());
    }

    protected function getCountingOperation() : AggregationOperation
    {
        $idColumn = $this->getPrimaryKeyColumn();
        return CountOperation::create()->addAggregationColumn($idColumn);
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

    protected function getDateGroupedRowsCountOperationGroup() : OperationGroup
    {
        $dateColumn = $this->getDateColumn();
        $countingOp = $this->getCountingOperation();

        return OperationGroup::create( $this->getOperationGroupTableName() )
                             ->enableDateSensitivity($dateColumn)
                             ->addOperation($countingOp);
    }

    public function getDefaultAdvancedOperations() : array
    {
        return [
            $this->getDateGroupedRowsCountOperationGroup()
        ];
    }

}

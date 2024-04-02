<?php

namespace Statistics\DataResources\ExistsStatisticalDataHandlerDataResources;

use DataResourceInstructors\OperationContainers\OperationGroups\OperationGroup;
use DataResourceInstructors\OperationTypes\AggregationOperation;
use Statistics\DataProcessors\DataProcessor;
use Statistics\DataResources\DataResource;
use Statistics\DateProcessors\DateProcessor;
use Statistics\OperationsManagement\OperationTempHolders\DataResourceOperationsTempHolder;
use Statistics\OperationsManagement\OperationTempHolders\OperationsTempHolder;
use Statistics\StatisticsProviders\StatisticsProviderDecorator;

class StatisticsProviderDataHandlerDataResource extends DataResource
{
    protected StatisticsProviderDecorator $statisticsProvider ;
    public function __construct(StatisticsProviderDecorator $statisticsProvider , DataResourceOperationsTempHolder $operationsTempHolder, DataProcessor $dataProcessor, ?DateProcessor $dateProcessor = null)
    {
        $this->setStatisticsProvider($statisticsProvider);
        parent::__construct($operationsTempHolder, $dataProcessor, $dateProcessor);
    }

    /**
     * @param StatisticsProviderDecorator $statisticsProvider
     * @return $this
     */
    public function setStatisticsProvider(StatisticsProviderDecorator $statisticsProvider): self
    {
        $this->statisticsProvider = $statisticsProvider;
        return $this;
    }

    static public function getAcceptedOperationTempHolderClass(): string
    {
        return OperationsTempHolder::class;
    }

    protected function processData(array $data) : array
    {
        return $this->dataProcessor->setInstanceProps($data , $this->currentOperationGroup , $this->dateProcessor)
            ->getProcessedData();
    }

    protected function setStatistics() : void
    {
        $this->statistics = $this->processData( $this->statisticsProvider->getCurrentStatisticsProviderData() );;
    }
}
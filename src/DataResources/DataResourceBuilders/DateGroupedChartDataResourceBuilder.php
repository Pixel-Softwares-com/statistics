<?php

namespace Statistics\DataResources\DataResourceBuilders;

use Exception;
use Statistics\DataProcessors\DataProcessor;
use Statistics\DataProcessors\DBFetchedDataProcessors\ChartDataProcessors\DateGroupedChartDataProcessor;
use Statistics\DataResources\DataResource;
use Statistics\DataResources\DataResourceBuilders\Traits\DataProcessorSettingMethods;
use Statistics\DataResources\DataResourceBuilders\Traits\DateProcessorSettingMethods;
use Statistics\DataResources\DataResourceBuilders\Traits\NeedsOperationInstructorsMethods;
use Statistics\DataResources\DBFetcherDataResources\ChartDataResources\DateGroupedChartDataResource\DateGroupedChartDataResourceTypes\DateGroupedCountChartDataResource;
use Statistics\DateProcessors\DateProcessor;
use Statistics\DateProcessors\NeededDateProcessorDeterminers\DateGroupedDateProcessorDeterminer;
use Statistics\DateProcessors\NeededDateProcessorDeterminers\NeededDateProcessorDeterminer;
use Statistics\Interfaces\DataResourceInterfaces\DataResourceBuilderInterfaces\NeedsOperationInstructors;

class DateGroupedChartDataResourceBuilder extends DataResourceBuilder implements  NeedsOperationInstructors
{
    use NeedsOperationInstructorsMethods , DateProcessorSettingMethods , DataProcessorSettingMethods;

    protected string $dateProcessorDeterminerClass = DateGroupedDateProcessorDeterminer::class;
    protected string $dataProcessorClass = DateGroupedChartDataProcessor::class;
    protected string $dataResourceClass = DateGroupedCountChartDataResource::class;

    protected function prepareDataResourceComponents() : void
    {
        $this->prepareOperationsTempHolder();
        $this->prepareDateProcessor();
    }
    public function getDataResource() : DataResource
    {
        $this->prepareDataResourceComponents();
        return $this->initDataResource()
                             ->setDateProcessor( $this->getDateProcessor() )
                             ->setDataProcessor( $this->initDataProcessor() )
                             ->setOperationsTempHolder( $this->getOperationsTempHolder() );
    }
}
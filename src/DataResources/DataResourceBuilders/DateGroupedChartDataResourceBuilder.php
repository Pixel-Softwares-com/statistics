<?php

namespace Statistics\DataResources\DataResourceBuilders;

use ReflectionException;
use Statistics\DataProcessors\DataProcessorTypes\DBFetchedDataProcessors\ChartDataProcessors\DateGroupedChartDataProcessor;
use Statistics\DataResources\DataResource;
use Statistics\DataResources\DataResourceBuilders\Traits\DataProcessorSettingMethods;
use Statistics\DataResources\DataResourceBuilders\Traits\DateProcessorSettingMethods;
use Statistics\DataResources\DataResourceBuilders\Traits\NeedsOperationInstructorsMethods;
use Statistics\DataResources\DBFetcherDataResources\ChartDataResources\DateGroupedChartDataResource\DateGroupedChartDataResourceTypes\DateGroupedMixChartDataResource;
use Statistics\DateProcessors\NeededDateProcessorDeterminers\DateGroupedDateProcessorDeterminer;
use Statistics\Interfaces\DataResourceInterfaces\DataResourceBuilderInterfaces\NeedsOperationInstructors;

class DateGroupedChartDataResourceBuilder extends DataResourceBuilder implements  NeedsOperationInstructors
{
    use NeedsOperationInstructorsMethods , DateProcessorSettingMethods , DataProcessorSettingMethods;

    protected string $dateProcessorDeterminerClass = DateGroupedDateProcessorDeterminer::class;
    protected string $dataProcessorClass = DateGroupedChartDataProcessor::class;
    protected string $dataResourceClass = DateGroupedMixChartDataResource::class;

    /**
     * @throws ReflectionException
     */
    protected function prepareDataResourceComponents() : void
    {
        $this->prepareOperationsTempHolder();
        $this->prepareDateProcessor();
    }

    /**
     * @throws ReflectionException
     */
    public function getDataResource() : DataResource
    {
        $this->prepareDataResourceComponents();
        return $this->initDataResource()
                             ->setDateProcessor( $this->getDateProcessor() )
                             ->setDataProcessor( $this->initDataProcessor() )
                             ->setOperationsTempHolder( $this->getOperationsTempHolder() );
    }
}
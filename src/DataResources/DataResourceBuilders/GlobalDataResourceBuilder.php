<?php

namespace Statistics\DataResources\DataResourceBuilders;

use ReflectionException;
use Statistics\DataProcessors\DBFetchedDataProcessors\GlobalDataProcessor;
use Statistics\DataResources\DataResource;
use Statistics\DataResources\DataResourceBuilders\Traits\DataProcessorSettingMethods;
use Statistics\DataResources\DataResourceBuilders\Traits\DateProcessorSettingMethods;
use Statistics\DataResources\DataResourceBuilders\Traits\NeedsOperationInstructorsMethods;
use Statistics\DataResources\DBFetcherDataResources\GlobalDataResource\GlobalDataResource;
use Statistics\DateProcessors\NeededDateProcessorDeterminers\GlobalDateProcessorDeterminer;
use Statistics\Interfaces\DataResourceInterfaces\DataResourceBuilderInterfaces\NeedsOperationInstructors;

class GlobalDataResourceBuilder extends DataResourceBuilder implements NeedsOperationInstructors
{

    use NeedsOperationInstructorsMethods, DateProcessorSettingMethods, DataProcessorSettingMethods;

    protected string $dateProcessorDeterminerClass = GlobalDateProcessorDeterminer::class;
    protected string $dataProcessorClass = GlobalDataProcessor::class;
    protected string $dataResourceClass = GlobalDataResource::class;


    /**
     * @throws ReflectionException
     */
    protected function prepareDataResourceComponents(): void
    {
        $this->prepareOperationsTempHolder();
        $this->prepareDateProcessor();
    }

    /**
     * @throws ReflectionException
     */
    public function getDataResource(): DataResource
    {
        $this->prepareDataResourceComponents();
        return $this->initDataResource()
            ->setDateProcessor($this->getDateProcessor())
            ->setDataProcessor($this->initDataProcessor())
            ->setOperationsTempHolder($this->getOperationsTempHolder());
    }
}
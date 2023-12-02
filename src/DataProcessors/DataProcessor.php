<?php

namespace Statistics\DataProcessors;

use Statistics\DataProcessors\Traits\DataProcessorSingleInstanceMethods;
use Statistics\DateProcessors\DateProcessor;
use Statistics\DateProcessors\DateProcessorTypes\DateGroupedChartDateProcessors\DateGroupedChartDateProcessor;
use DataResourceInstructors\OperationContainers\OperationGroups\OperationGroup;
use Illuminate\Support\Str;

abstract class DataProcessor
{
    use DataProcessorSingleInstanceMethods;

    protected array $processedData = [];
    protected array $dataToProcess = [];
    protected  DateProcessor | DateGroupedChartDateProcessor | null $dateProcessor = null;
    protected OperationGroup $operationGroup;


    protected function __construct()
    {

    }


    /**
     * @param OperationGroup $operationGroup
     * @return $this
     */
    public function setOperationGroup(OperationGroup $operationGroup): DataProcessor
    {
        $this->operationGroup = $operationGroup;
        return $this;
    }

    protected function processData() : void
    {
        /**  Default Implementation Until The Child Override The Method */
        $this->processedData = $this->dataToProcess;
    }
    protected function getProcessedDataResultKey() : string
    {
        return $this->operationGroup->getResultArrayKey();
    }

    protected function wrapProcessedDataInResultKey() : void
    {
        $key = $this->getProcessedDataResultKey();
        if($key)
        {
            $this->processedData = [$key => $this->processedData];
        }
    }

    protected function convertStdObjectsToDataPureArray() : void
    {
        foreach ($this->dataToProcess as $index => $stdClass)
        {
            $this->dataToProcess[$index] = (array) $stdClass;
        }
    }
    /**
     * @return array
     */
    public function getProcessedData(): array
    {
        $this->convertStdObjectsToDataPureArray();
        $this->processData();
        $this->wrapProcessedDataInResultKey();
        return $this->processedData;
    }

}

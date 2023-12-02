<?php

namespace Statistics\DataProcessors\DBFetchedDataProcessors\ChartDataProcessors;

use Statistics\DataProcessors\DBFetchedDataProcessors\GlobalDataProcessor;
use Statistics\DataProcessors\Traits\NumericValuesPercentageCalculatingMethods;

class PercentageGroupedChartDataProcessor extends GlobalDataProcessor
{
    use NumericValuesPercentageCalculatingMethods;

    protected function setProcessedKeysPercentageValue() : void
    {
        foreach ($this->processedData as $key => $value)
        {
            $this->processedData[$key] = $this->getProcessedKeyPercentageValue($value);
        }
    }

    protected function prepareDataToProcess() : void
    {
        /** To Avoid Processing Missed Values In Parent Class .... Because IT Is Not Necessary Here */
        return;
    }

    protected function processData() : void
    {
        parent::processData();
        $this->setProcessedKeysPercentageValue();
    }
}

<?php

namespace Statistics\DataProcessors\DataProcessorTypes\DBFetchedDataProcessors\ChartDataProcessors;

use Statistics\DataProcessors\DataProcessorTypes\DBFetchedDataProcessors\GlobalDataProcessor;
use Statistics\DataProcessors\Traits\NumericValuesPercentageCalculatingMethods;

class PercentageGroupedChartDataProcessor extends GlobalDataProcessor
{
    use NumericValuesPercentageCalculatingMethods;


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

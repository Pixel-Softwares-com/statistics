<?php

namespace Statistics\DataProcessors\DataProcessingFuncs\Traits;

trait NumericValuesPercentageCalculatingMethods
{
    protected int $totalOfNumericValue = 0;

    /**
     * On aggregating value processing in parent DataProcessor (GlobalDataProcessor) ... the value will be catched and added to totalOfNumericValue
     * to avoid loop the values again while determining totalOfNumericValue that used in percentage equation
     */
    protected function getAggregatingValue(string $aggregationColumnAlias ,array $dataRow = [] ) : int
    {
        $value = parent::getAggregatingValue($aggregationColumnAlias , $dataRow);
        $this->totalOfNumericValue += $value;
        return $value;
    }

    protected function getProcessedKeyPercentageValue(int $aggregatingValue) : float
    {
        if($this->totalOfNumericValue <= 0){$this->totalOfNumericValue = 1;}
        return  round( floatVal($aggregatingValue * 100 / $this->totalOfNumericValue ) , 2  );
    }
    protected function setProcessedKeysPercentageValue() : void
    {
        foreach ($this->processedData as $key => $value)
        {
            $this->processedData[$key] = $this->getProcessedKeyPercentageValue($value);
        }
    }
}

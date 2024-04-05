<?php

namespace Statistics\DataProcessors\Traits;

trait NumericValuesPercentageCalculatingMethods
{
    protected int $totalOfNumericValue = 0;
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

<?php

namespace Statistics\DataProcessors\DataProcessorTypes;

use Illuminate\Support\Arr;
use Statistics\DataProcessors\DataProcessor;

class ExistsStatisticsProviderDataProcessor extends DataProcessor
{
    protected string $ProcessedDataResultKey = "";

    protected function getProcessedDataResultKey() : string
    {
        return $this->ProcessedDataResultKey;
    }

    protected function setProcessedDataResultKey(array $dataToProcess): void
    {
        $this->ProcessedDataResultKey =  array_key_first($dataToProcess) ?? "";
    }
    public function setDataToProcess(array $dataToProcess): self
    {
        $this->setProcessedDataResultKey($dataToProcess);
        return parent::setDataToProcess( Arr::first( $dataToProcess ) ?? [] );
    }

    public function getProcessedData(): array
    {
        $this->setInitProcessedData();
        $this->processData();
        $this->wrapProcessedDataInResultKey();
        return $this->processedData;
    }
    protected function getAggregatingValue(string $aggregationColumnAlias ,array $dataRow = [] ) : int
    {
        return $dataRow[$aggregationColumnAlias] ?? 0;
    }
    protected function processData( ) : void
    {
        foreach ($this->dataToProcess as $label => $value)
        {
            $this->processedData[$label] = $this->getAggregatingValue($label , $this->dataToProcess);
        }
    }
}
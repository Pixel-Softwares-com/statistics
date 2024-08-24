<?php

namespace Statistics\DataProcessors\DataProcessorTypes\DBFetchedDataProcessors;

abstract class BooleanKeysDataProcessor extends GlobalDataProcessor
{
    abstract function getTrueSituationStringKey() : string;
    abstract function getFalseSituationStringKey() : string;

    protected function convertBooleanKeysToStringValues() : void
    {
        if(array_key_exists(true , $this->processedData))
        {
            $this->processedData[$this->getTrueSituationStringKey()] = $this->processedData[true];
            unset($this->processedData[true]);
        }

        if(array_key_exists(false , $this->processedData))
        {
            $this->processedData[$this->getFalseSituationStringKey()] = $this->processedData[false];
            unset($this->processedData[false]);
        }
    }
    protected function processData(): void
    {
        parent::processData();
        $this->convertBooleanKeysToStringValues();
    }

}

<?php

namespace Statistics\DataProcessors\DataProcessingFuncs\RequiredValuesValidators\Traits;

trait Getters
{

    public function getMissedDataRows() : array
    {
        return $this->missedDataRows;
    }
}

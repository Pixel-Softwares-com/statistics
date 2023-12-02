<?php

namespace Statistics\DataProcessors\RequiredValuesValidators\Traits;

trait Getters
{

    public function getMissedDataRows() : array
    {
        return $this->missedDataRows;
    }
}

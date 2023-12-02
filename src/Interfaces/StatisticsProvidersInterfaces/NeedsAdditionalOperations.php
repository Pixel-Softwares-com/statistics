<?php

namespace Statistics\Interfaces\StatisticsProvidersInterfaces;

interface NeedsAdditionalOperations
{
    public function getAdditionalOperations() : array;
}

<?php

namespace Statistics\StatisticsProviders\Traits;

use Statistics\DataProcessors\DataProcessor;
use Statistics\DateProcessors\NeededDateProcessorDeterminers\NeededDateProcessorDeterminer;

trait StatisticsProviderAbstractMethods
{


    /**
     * @return string
     * Must Returns The Key String Will Be Set In The Final Statistics Array To Avoid Pushing A Statistics Indexed Array
     */
    abstract public function getStatisticsTypeName() : string;


    abstract protected function getDataResourceBuildersOrdersByPriorityClasses()  :array;
}

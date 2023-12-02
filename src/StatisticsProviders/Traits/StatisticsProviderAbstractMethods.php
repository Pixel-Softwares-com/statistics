<?php

namespace Statistics\StatisticsProviders\Traits;

use Statistics\DataProcessors\DataProcessor;
use Statistics\DateProcessors\NeededDateProcessorDeterminers\NeededDateProcessorDeterminer;

trait StatisticsProviderAbstractMethods
{

//    abstract protected function getModelClass() : string;

    /**
     * @return string
     * Must Returns The Key String Will Be Set In The Final Statistics Array To Avoid Pushing A Statistics Indexed Array
     */
    abstract protected function getStatisticsTypeName() : string;

    /**
     * @return NeededDateProcessorDeterminer
     */
    abstract protected function getNeededDateProcessorDeterminerInstance() : NeededDateProcessorDeterminer;

    abstract protected function getDataResourceOrdersByPriorityClasses()  :array;
    abstract protected  function getDataProcessorInstance() : DataProcessor;
}

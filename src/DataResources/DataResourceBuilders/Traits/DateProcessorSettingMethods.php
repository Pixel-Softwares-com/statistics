<?php

namespace Statistics\DataResources\DataResourceBuilders\Traits;

use ReflectionException;
use Statistics\DateProcessors\DateProcessor;
use Statistics\DateProcessors\NeededDateProcessorDeterminers\DateGroupedDateProcessorDeterminer;
use Statistics\DateProcessors\NeededDateProcessorDeterminers\NeededDateProcessorDeterminer;

trait DateProcessorSettingMethods
{
    protected function initDateProcessor() : ?DateProcessor
    {
        /**  @var NeededDateProcessorDeterminer $dateProcessorDeterminer  */
        $dateProcessorDeterminer = $this->dateProcessorDeterminerClass::Singleton();
        return $dateProcessorDeterminer->getDateProcessorInstance();
    }

    /**
     * @throws ReflectionException
     */
    protected function prepareDateProcessor() : void
    {
        if($this->dateProcessorDeterminerClass)
        {
            $this->checkDateProcessorDeterminerClassType($this->dateProcessorDeterminerClass);
            $this->dateProcessor = $this->initDateProcessor();
        }
    }

}
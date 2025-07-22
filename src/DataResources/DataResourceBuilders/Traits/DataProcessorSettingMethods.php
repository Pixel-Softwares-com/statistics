<?php

namespace Statistics\DataResources\DataResourceBuilders\Traits;

use ReflectionException;
use Statistics\DataProcessors\DataProcessor;

trait DataProcessorSettingMethods
{
 
    /**
     * @throws ReflectionException
     */
    protected function initDataProcessor() : DataProcessor
    {
        $this->checkDataProcessorClassType($this->dataProcessorClass);

        /**  @var DataProcessor $dataProcessor  */
        $dataProcessor = $this->dataProcessorClass::Singleton();
        return $dataProcessor->setDateProcessor( $this->getDateProcessor() );

    }
}
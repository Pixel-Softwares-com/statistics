<?php

namespace Statistics\StatisticsBuilderBaseService;

use Statistics\StatisticsProviders\StatisticsProviderDecorator;
use Exception;
use ReflectionException;

/**
 * This Service Is Like A Class Builder .... To Wrap The Decorators Over each other
 */
abstract class StatisticsBuilderBaseService
{
    protected ?StatisticsProviderDecorator $statisticsProvider = null;

    abstract protected function getStatisticsProviderTypeClasses() : array;

    /**
     * @return void
     */
    protected function setStatisticsProviderProps() : void
    {
        return;
    }

    /**
     * @param string $StatisticsProviderDecoratorClass
     */
    protected function buildStatisticsProvider(string $StatisticsProviderDecoratorClass)  : void
    {
        if(class_exists($StatisticsProviderDecoratorClass))
        {
            $StatisticsProviderDecoratorClass = new $StatisticsProviderDecoratorClass($this->statisticsProvider);
            if($StatisticsProviderDecoratorClass instanceof StatisticsProviderDecorator)
            {
                $this->statisticsProvider = $StatisticsProviderDecoratorClass;
                $this->setStatisticsProviderProps();
            }
        }
    }

    /**
     * @return void
     */
    protected function buildStatisticsProviders()  :void
    {
        foreach ($this->getStatisticsProviderTypeClasses() as $providerType)
        {
            $this->buildStatisticsProvider($providerType);
        }
    }

    /**
     * @return array
     * @throws Exception
     * @throws ReflectionException
     */
    public function getStatistics()  :array
    {
        $this->buildStatisticsProviders();
        return $this->statisticsProvider?->getStatistics() ?? [];
    }

}

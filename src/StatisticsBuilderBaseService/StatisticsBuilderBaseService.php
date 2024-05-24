<?php

namespace Statistics\StatisticsBuilderBaseService;

use Statistics\StatisticsBuilderBaseService\BuildingHelpers\StatisticsProviderReformulatingParametersBinder;
use Statistics\StatisticsProviders\StatisticsProviderDecorator;
use Exception;
use ReflectionException;

/**
 * This Service Is Like A Class Builder .... To Wrap The Decorators Over each other
 */
abstract class StatisticsBuilderBaseService
{
    protected ?StatisticsProviderDecorator $statisticsProvider = null;
    protected ?StatisticsProviderReformulatingParametersBinder $StatisticsProviderParametersBinder = null;

    abstract protected function getStatisticsProviderTypeClasses() : array;

    /**
     * @throws ReflectionException
     */
    protected function getStatisticsProvidersData() : array
    {
        return $this->statisticsProvider?->getStatistics() ?? [];
    }
    protected function initStatisticsProviderReformulatingParametersBinder() : StatisticsProviderReformulatingParametersBinder
    {
        if(!$this->StatisticsProviderParametersBinder)
        {
            $this->StatisticsProviderParametersBinder = StatisticsProviderReformulatingParametersBinder::initBinder();
        }
        return $this->StatisticsProviderParametersBinder;
    }

    protected function bindStatisticsProviderReformulatingParameters() :void
    {
        $this->initStatisticsProviderReformulatingParametersBinder()->bind();
    }
    /**
     * @return void
     */
    protected function customizeCurrentStatisticsProviderInitializing() : void
    {
        return;
    }

    protected function prepareReformulatingParameterBinding(StatisticsProviderDecorator $StatisticsProviderDecorator) : void
    {
        $this->initStatisticsProviderReformulatingParametersBinder()->categoryStatisticsProvider($StatisticsProviderDecorator);
    }
    protected function decorateStatisticsProvider(StatisticsProviderDecorator $StatisticsProviderDecorator) : void
    {
        $this->statisticsProvider = $StatisticsProviderDecorator;
    }
    protected function initStatisticsProvider(string $StatisticsProviderDecoratorClass) : ?StatisticsProviderDecorator
    {
        if(class_exists($StatisticsProviderDecoratorClass) && is_subclass_of($StatisticsProviderDecoratorClass , StatisticsProviderDecorator::class))
        {
            return new $StatisticsProviderDecoratorClass($this->statisticsProvider);
        }
        return null;
    }
    /**
     * @param string $StatisticsProviderDecoratorClass
     */
    protected function buildStatisticsProvider(string $StatisticsProviderDecoratorClass)  : void
    {
        if($StatisticsProviderDecorator = $this->initStatisticsProvider($StatisticsProviderDecoratorClass))
        {
                $this->decorateStatisticsProvider($StatisticsProviderDecorator);
                $this->prepareReformulatingParameterBinding($StatisticsProviderDecorator);
                $this->customizeCurrentStatisticsProviderInitializing();
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
        $this->bindStatisticsProviderReformulatingParameters();
        return $this->getStatisticsProvidersData();
    }

}

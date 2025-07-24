<?php

namespace Statistics\StatisticsBuilderBaseService;

use Statistics\StatisticsBuilderBaseService\BuildingHelpers\StatisticsProviderReformulatingParametersBinder;
use Statistics\StatisticsBuilderBaseService\BuildingHelpers\StatisticsProvidersCategorizer;
use Statistics\StatisticsProviders\StatisticsProviderDecorator;
use Exception;
use ReflectionException;

/**
 * This Service Is Like A Class Builder .... To Wrap The Decorators Over each other
 */
abstract class StatisticsBuilderBaseService
{
    protected ?StatisticsProviderDecorator $statisticsProvider = null;
    protected ?StatisticsProvidersCategorizer $StatisticsProvidersCategorizer = null;

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
        return StatisticsProviderReformulatingParametersBinder::initBinder();
    }

    protected function initStatisticsProvidersCategorizer() : StatisticsProvidersCategorizer
    {
        if(!$this->StatisticsProvidersCategorizer)
        {
            $this->StatisticsProvidersCategorizer = new StatisticsProvidersCategorizer();
        }

        return $this->StatisticsProvidersCategorizer;
    }

    protected function bindStatisticsProviderReformulatingParameters() :void
    {
        $this->initStatisticsProviderReformulatingParametersBinder()
             ->bind( $this->initStatisticsProvidersCategorizer() );
    }

    /**
     * @return void
     */
    protected function customizeCurrentStatisticsProviderInitializing() : void
    {
        return;
    }

    protected function decorateStatisticsProvider(StatisticsProviderDecorator $StatisticsProviderDecorator) : void
    {
        $this->statisticsProvider = $StatisticsProviderDecorator;
    }

    protected function setStatisticsProviderProps(StatisticsProviderDecorator $StatisticsProviderDecorator) : void
    {

        $StatisticsProviderDecorator->setStatisticsProvider($this->statisticsProvider);
    }

    /**
     * @return array
     *
     * this method uses StatisticsProvidersCategorizer to validate and initialize and order the statistics providers
     *
     * THe providers those needs data from another providers must be wrapped first to allow the data owned providers to be called first
     * (wrapped first ===> called at the end , and wrapped at the end ===> called first)
     *(the decorator loop works form the end to start .... so the data owned providers must be in the end of the decorating loop)
     */
    protected function getOrderedValidStatisticsProviders() : array
    {
        return $this->initStatisticsProvidersCategorizer()
                    ->setStatisticsProvidersClass( $this->getStatisticsProviderTypeClasses() )
                    ->getOrderedValidStatisticsProviders();
    }

    protected function getDecoratableOrderedValidStatisticsProvidersArray() : array
    {
        return array_reverse( $this->getOrderedValidStatisticsProviders() );
    }

    protected function buildStatisticsProviders()  :void
    {
        foreach ($this->getDecoratableOrderedValidStatisticsProvidersArray() as $provider )
        {
            $this->setStatisticsProviderProps($provider); // setting default props
            $this->decorateStatisticsProvider($provider); // implementing decorator design pattern
            $this->customizeCurrentStatisticsProviderInitializing(); // hook method for child class
        }
        
        $this->bindStatisticsProviderReformulatingParameters(); // Ensuring all necessary providers is properly passed as required.
    }

    /**
     * @return array
     * @throws Exception
     * @throws ReflectionException
     */
    public function getStatistics()  :array
    {
        $this->buildStatisticsProviders();
        return $this->getStatisticsProvidersData();
    }

}

<?php

namespace Statistics\StatisticsBuilderBaseService\BuildingHelpers;

use Illuminate\Contracts\Support\Arrayable;
use Statistics\Interfaces\StatisticsProvidersInterfaces\HasReformulatableData;
use Statistics\Interfaces\StatisticsProvidersInterfaces\ReformulatesStatisticsProviderData;
use Statistics\StatisticsProviders\StatisticsProviderDecorator;

class StatisticsProvidersCategorizer implements Arrayable
{
    protected array $statisticsProvidersClass = [];

    protected array $normalPrioritedStatisticsProviders = [];
    protected array $ReformatorStatisticsProviders = [];
    protected array $ReforulatableStatisticsProviders = [];
    public function __construct(array $statisticsProvidersClass = [])
    {
        $this->setStatisticsProvidersClass($statisticsProvidersClass);
    }

    /**
     * @return array<ReformulatesStatisticsProviderData|StatisticsProviderDecorator>
     */
    public function getReformatorStatisticsProviders(): array
    {
        return $this->ReformatorStatisticsProviders;
    }

    /**
     * @return array<HasReformulatableData|StatisticsProviderDecorator>
     */
    public function getReforulatableStatisticsProviders(): array
    {
        return $this->ReforulatableStatisticsProviders;
    }

    /**
     * @return array
     */
    public function getNormalPrioritedStatisticsProviders(): array
    {
        return $this->normalPrioritedStatisticsProviders;
    }
    /**
     * @param array $statisticsProvidersClass
     * @return $this
     */
    public function setStatisticsProvidersClass(array $statisticsProvidersClass): self
    {
        $this->statisticsProvidersClass = $statisticsProvidersClass;
        return $this;
    }
    protected function orderNormalPrioritedStatisticsProvider(StatisticsProviderDecorator $statisticsProvider) : void
    {
        $key = get_class($statisticsProvider);
        $this->normalPrioritedStatisticsProviders[ $key ] = $statisticsProvider;
    }
    public static function DoesItHaveReforulatableData(StatisticsProviderDecorator $statisticsProvider ) : bool
    {
        return $statisticsProvider instanceof HasReformulatableData;
    }
    protected function orderReformulatableSatisticsProvider(StatisticsProviderDecorator $statisticsProvider) : bool
    {
        if($this::DoesItHaveReforulatableData($statisticsProvider))
        {
            $key = get_class($statisticsProvider);
            $this->ReforulatableStatisticsProviders[ $key ] = $statisticsProvider;
            return true;
        }
        return false;
    }
    public static function DoesItReformulateStatisticsProviderData(StatisticsProviderDecorator $statisticsProvider ) : bool
    {
        return $statisticsProvider instanceof ReformulatesStatisticsProviderData;
    }
    protected function orderReformatorSatisticsProvider(StatisticsProviderDecorator $statisticsProvider) : bool
    {
        if($this::DoesItReformulateStatisticsProviderData($statisticsProvider))
        {
            $key = get_class($statisticsProvider);
            $this->ReformatorStatisticsProviders[ $key ] = $statisticsProvider;
            return true;
        }
        return false;
    }
    protected function orderStatisticsProvider(StatisticsProviderDecorator $statisticsProvider) : void
    {
        if ( $this->orderReformatorSatisticsProvider($statisticsProvider) ) { return; }
        if( $this->orderReformulatableSatisticsProvider($statisticsProvider) ) {return ;}

        /**
         * The default behavior
         */
        $this->orderNormalPrioritedStatisticsProvider($statisticsProvider);
    }
    protected function initProvider(string $statisticsProvidersClass = "") : ?StatisticsProviderDecorator
    {
        if(class_exists($statisticsProvidersClass) && is_subclass_of($statisticsProvidersClass , StatisticsProviderDecorator::class))
        {
            return new $statisticsProvidersClass();
        }
        return null;
    }
    protected function processClasses() : void
    {
        foreach ($this->statisticsProvidersClass as $statisticsProviderClass)
        {
            if($provider = $this->initProvider($statisticsProviderClass))
            {
                $this->orderStatisticsProvider($provider);
            }
        }
    }

    public function toArray()
    {
        return array_merge($this->normalPrioritedStatisticsProviders , $this->ReformatorStatisticsProviders , $this->ReforulatableStatisticsProviders);
    }

    /**
     * @return array<StatisticsProviderDecorator>
     */
    public function getOrderedValidStatisticsProviders() : array
    {
        $this->processClasses();
        return $this->toArray();
    }
}
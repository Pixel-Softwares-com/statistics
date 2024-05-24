<?php

namespace Statistics\StatisticsBuilderBaseService\BuildingHelpers;

use Statistics\Interfaces\StatisticsProvidersInterfaces\HasReformulatableData;
use Statistics\Interfaces\StatisticsProvidersInterfaces\ReformulatesStatisticsProviderData;
use Statistics\StatisticsProviders\StatisticsProviderDecorator;

class StatisticsProviderReformulatingParametersBinder
{
    protected array $reformulatableStatisticsProviders = [];
    protected array $reformartorStatisticsProviders = [];

    public static function initBinder() : self
    {
        return new static();
    }
    protected function addReformulatableStatisticsProvider(HasReformulatableData $statisticsProvider ) : self
    {
        $searchingKey = get_class($statisticsProvider);
        $this->reformulatableStatisticsProviders[ $searchingKey ] = $statisticsProvider;
        return $this;
    }
    protected function addReformartorStatisticsProvider(ReformulatesStatisticsProviderData $statisticsProvider ) : self
    {
        $searchingKey = get_class($statisticsProvider);
        $this->reformartorStatisticsProviders[$searchingKey] = $statisticsProvider;
        return $this;
    }
    public function categoryStatisticsProvider(StatisticsProviderDecorator $statisticsProvider) : self
    {
        if($statisticsProvider instanceof ReformulatesStatisticsProviderData)
        {
            return $this->addReformartorStatisticsProvider($statisticsProvider);
        }

        if($statisticsProvider instanceof HasReformulatableData)
        {
            return $this->addReformulatableStatisticsProvider($statisticsProvider);
        }
        return $this;
    }

    protected function getReformulatable(ReformulatesStatisticsProviderData $reformator) : ?HasReformulatableData
    {
        $reformulatableClass = $reformator->getReformulatableStatisticsProviderClass();
        return $this->reformulatableStatisticsProviders[$reformulatableClass] ?? null;
    }
    public function bind() : void
    {
        array_map(function(ReformulatesStatisticsProviderData $reformator)
        {
            if($reformulatableStatisticsProvider = $this->getReformulatable($reformator))
            {
                $reformator->setReformulatableStatisticsProvider($reformulatableStatisticsProvider);
            }
        } , $this->reformartorStatisticsProviders);
    }
}
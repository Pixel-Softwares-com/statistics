<?php

namespace Statistics\StatisticsBuilderBaseService\BuildingHelpers;

use Statistics\Interfaces\StatisticsProvidersInterfaces\HasReformulatableData;
use Statistics\Interfaces\StatisticsProvidersInterfaces\ReformulatesStatisticsProviderData;
use Statistics\StatisticsProviders\StatisticsProviderDecorator;

class StatisticsProviderReformulatingParametersBinder
{
    protected bool $addedLastStatisticsProviderDeferredStatus = false;
    protected array $reformulatableStatisticsProviders = [];

    /** must be deferred until the related refomulatableStatisticsProvider gets its data */
    protected array $reformartorStatisticsProviders = [];

    public static function initBinder() : self
    {
        return new static();
    }
/*    protected function addReformulatableStatisticsProvider(HasReformulatableData $statisticsProvider ) : self
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
    }*/

//    public function categoryStatisticsProvider(StatisticsProviderDecorator $statisticsProvider) : self
//    {
//        if($statisticsProvider instanceof ReformulatesStatisticsProviderData)
//        {
//            return $this->addReformartorStatisticsProvider($statisticsProvider);
//        }
//
//        if($statisticsProvider instanceof HasReformulatableData)
//        {
//            return $this->addReformulatableStatisticsProvider($statisticsProvider);
//        }
//        return $this;
//    }

    protected function DoesItHaveReforulatableData(StatisticsProviderDecorator $statisticsProviderDecorator)
    {
        return StatisticsProvidersCategorizer::DoesItHaveReforulatableData($statisticsProviderDecorator);
    }
    protected function DoesItReformulateStatisticsProviderData(StatisticsProviderDecorator $statisticsProviderDecorator)
    {
        return StatisticsProvidersCategorizer::DoesItReformulateStatisticsProviderData($statisticsProviderDecorator);
    }

    protected function getReformulatable(ReformulatesStatisticsProviderData $reformator) : ?HasReformulatableData
    {
        $reformulatableClass = $reformator->getReformulatableStatisticsProviderClass();
        return $this->reformulatableStatisticsProviders[$reformulatableClass] ?? null;
    }
    protected function handleStatisticsProviderSearchingKey(array $statisticsProviders = []) : array
    {
        $newArray = [];
        array_walk($statisticsProviders, function($provider, $providerClass) use (&$newArray)
        {
            if (is_numeric($providerClass))
            {
                $providerClass = get_class($provider);
            }
            $newArray[$providerClass] = $provider;
        });
        return $newArray;
//        foreach ($reformartorStatisticsProviders as $providerClass => $provider)
//        {
//            if(is_numeric($providerClass))
//            {
//                $reformartorStatisticsProviders[ get_class($provider) ] = $provider;
//                unset($reformartorStatisticsProviders[$providerClass]);
//            }
//        }
//        array_map(function($value , $key)
//        {
//            if(is_numeric($key))
//            {
//                return [ get_class($value) => $value ];
//            }
//            return $value;
//        } , $reformartorStatisticsProviders)
    }
    /**
     * @param array $reformartorStatisticsProviders
     */
    public function setReformartorStatisticsProviders(array $reformartorStatisticsProviders): void
    {
        $reformartorStatisticsProviders = $this->handleStatisticsProviderSearchingKey($reformartorStatisticsProviders);
        $this->reformartorStatisticsProviders = $reformartorStatisticsProviders;
    }

    /**
     * @param array $reformulatableStatisticsProviders
     */
    public function setReformulatableStatisticsProviders(array $reformulatableStatisticsProviders): void
    {
        $reformulatableStatisticsProviders = $this->handleStatisticsProviderSearchingKey($reformulatableStatisticsProviders);
        $this->reformulatableStatisticsProviders = $reformulatableStatisticsProviders;
    }
    protected function extractStatisticsProvidersCategorizerData(StatisticsProvidersCategorizer $categorizer) : void
    {
        $this->setReformartorStatisticsProviders( $categorizer->getReformatorStatisticsProviders() );
        $this->setReformulatableStatisticsProviders($categorizer->getReforulatableStatisticsProviders());
    }
    public function bind( StatisticsProvidersCategorizer $categorizer ) : void
    {
        $this->extractStatisticsProvidersCategorizerData($categorizer);

        array_map(function(ReformulatesStatisticsProviderData $reformator)
        {
            if($reformulatableStatisticsProvider = $this->getReformulatable($reformator))
            {
                $reformator->setReformulatableStatisticsProvider($reformulatableStatisticsProvider);
            }
        } , $this->reformartorStatisticsProviders);
    }
}
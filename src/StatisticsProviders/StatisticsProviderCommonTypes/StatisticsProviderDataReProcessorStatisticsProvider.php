<?php

namespace Statistics\StatisticsProviders\StatisticsProviderCommonTypes;

use Exception;
use Statistics\DataProcessors\DataProcessorTypes\DBFetchedDataProcessors\GlobalDataProcessor;
use Statistics\DataResources\DataResourceBuilders\StatisticsProviderDataHandlerResourceBuilder;
use Statistics\Interfaces\StatisticsProvidersInterfaces\HasReformulatableData;
use Statistics\Interfaces\StatisticsProvidersInterfaces\ReformulatesStatisticsProviderData;
use Statistics\StatisticsProviders\CustomizableStatisticsProvider;
use Statistics\StatisticsProviders\StatisticsProviderDecorator;

abstract class StatisticsProviderDataReProcessorStatisticsProvider extends CustomizableStatisticsProvider implements ReformulatesStatisticsProviderData
{
    protected StatisticsProviderDecorator | HasReformulatableData | null $reformulatableStatisticsProvider = null;

    public function setReformulatableStatisticsProvider(HasReformulatableData $reformulatableStatisticsProvider) : void
    {
        $this->reformulatableStatisticsProvider = $reformulatableStatisticsProvider;
    }

    /**
     * @throws Exception
     */
    protected function checkReformulatableStatisticsProvider() : void
    {
        if(!$this->reformulatableStatisticsProvider)
        {
            throw new Exception("No ReformulatableStatisticsProvider bound to this StatisticsProvider type .... No data to be reformatted !");
        }
    }

    /**
     * @throws Exception
     */
    public function getReformulatableStatisticsProvider() : HasReformulatableData
    {
        $this->checkReformulatableStatisticsProvider();
        return $this->reformulatableStatisticsProvider;
    }
    /**
     * @return string
     * Used to allow the child class to override the DataProcessor
     */
    public  static function getDataProcessorClass() : string
    {
        return GlobalDataProcessor::class;
    }

    /**
     * @return array
     * @throws Exception
     */
    protected function getDataResourceBuildersOrdersByPriorityClasses(): array
    {
        /**
         * @var StatisticsProviderDecorator $statisticsProvider
         */
        $statisticsProvider =  $this->getReformulatableStatisticsProvider() ;
        return [
            StatisticsProviderDataHandlerResourceBuilder::create()
                                                        ->setStatisticsProvider($statisticsProvider)
                                                        ->useDataProcessorClass( $this->getDataProcessorClass() )
        ];
    }

}
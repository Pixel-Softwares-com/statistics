<?php

namespace Statistics\DataResources\DBFetcherDataResources\ChartDataResources\DateGroupedChartDataResource\Traits;

use Statistics\DateProcessors\DateProcessorTypes\DateGroupedChartDateProcessors\RangePeriodDateProcessor;
use Statistics\DateProcessors\NeededDateProcessorDeterminers\NeededDateProcessorDeterminer;
use Statistics\QueryCustomizationStrategies\QueryCustomizationStrategy;

trait StrategiesDeterminingMethods
{

    protected function getQuarterAggregationOpStrategy() : QueryCustomizationStrategy
    {
        /** @var QueryCustomizationStrategy $queryCustomizerClass  */
        $queryCustomizerClass = $this->getQuarterAggregationOpStrategyClass();

        return $queryCustomizerClass::Singleton( 
                                                    $this->query,
                                                    $this->currentOperationGroup ,
                                                    $this->currentOperation,
                                                    $this->dateProcessor
                                               );
    }

    protected function getYearAggregationOpStrategy() : QueryCustomizationStrategy
    {
        /** @var QueryCustomizationStrategy $queryCustomizerClass  */
        $queryCustomizerClass = $this->getYearAggregationOpStrategyClass();
        return $queryCustomizerClass::Singleton( 
                                                    $this->query,
                                                    $this->currentOperationGroup ,
                                                    $this->currentOperation,
                                                    $this->dateProcessor
                                               );
    }

    protected function getMonthAggregationOpStrategy() : QueryCustomizationStrategy
    {
        /** @var QueryCustomizationStrategy $queryCustomizerClass  */
        $queryCustomizerClass = $this->getMonthAggregationOpStrategyClass();
        return $queryCustomizerClass::Singleton( 
                                                    $this->query,
                                                    $this->currentOperationGroup ,
                                                    $this->currentOperation,
                                                    $this->dateProcessor
                                               );
    }

    protected function getDayAggregationOpStrategy() : QueryCustomizationStrategy
    {
        /** @var QueryCustomizationStrategy $queryCustomizerClass  */
        $queryCustomizerClass = $this->getDayAggregationOpStrategyClass();
        return $queryCustomizerClass::Singleton( 
                                                    $this->query,
                                                    $this->currentOperationGroup ,
                                                    $this->currentOperation,
                                                    $this->dateProcessor
                                               );
    }
  protected function getSemiAnnulAggregationOpStrategy() : QueryCustomizationStrategy
    {
        /** @var QueryCustomizationStrategy $queryCustomizerClass  */
        $queryCustomizerClass = $this->getSemiAnnulAggregationOpStrategyClass();
        return $queryCustomizerClass::Singleton( 
                                                    $this->query,
                                                    $this->currentOperationGroup ,
                                                    $this->currentOperation,
                                                    $this->dateProcessor
                                               );
    }

    protected function getRangeAggregationOpStrategy() : QueryCustomizationStrategy
    {
        /**
         * @var RangePeriodDateProcessor $dataProcessor
         */
        $dataProcessor = RangePeriodDateProcessor::Singleton($this->request);
        $periodLengthDays = $dataProcessor->getPeriodLengthByDays();

        /** Any Condition Has True Value Will Be Reason To Return THe Convenient Strategy  */
        return match(true) 
        {
            ($periodLengthDays <= 31)                               => $this->getDayAggregationOpStrategy(),
            ($periodLengthDays > 31 && $periodLengthDays <= 124)    => $this->getMonthAggregationOpStrategy(),
            ($periodLengthDays > 124 && $periodLengthDays <= 366)   => $this->getQuarterAggregationOpStrategy(),
            default                                                 => $this->getYearAggregationOpStrategy()
        };
    }

    protected function getAggregationOpStrategy() : QueryCustomizationStrategy | null
    {
        return (match(NeededDateProcessorDeterminer::getPeriodTypeRequestValue())
        {
            'month'           => $this->getMonthAggregationOpStrategy(),
            'quarter'         => $this->getQuarterAggregationOpStrategy(),
            'year'            => $this->getYearAggregationOpStrategy(),
            'range'           => $this->getRangeAggregationOpStrategy(),
            'semi-annaul'     => $this->getSemiAnnulAggregationOpStrategy(),
            default     => $this->getDayAggregationOpStrategy()
        });
    }

}

<?php

namespace Statistics\DateProcessors\DateProcessorTypes\DateGroupedChartDateProcessors;

use Statistics\DateProcessors\DateProcessor;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;
use Generator;

abstract class DateGroupedChartDateProcessor extends DateProcessor
{

    abstract protected function getPeriodInterval() : CarbonInterval;
    abstract protected function getPeriodSingleDateFormat(Carbon $singleDate) : string;


    protected function getIntervalFinalForm(CarbonPeriod $interval) : Generator
    {
        return $interval->map(function (Carbon $singleDate)
        {
            return $this->getPeriodSingleDateFormat($singleDate);
        });
    }
    public function getIntervalBetweenDates(): array
    {
        $interval = $this->getStartingDate()->toPeriod($this->getEndingDate() ,  $this->getPeriodInterval());
        return iterator_to_array($this->getIntervalFinalForm($interval));

    }
}

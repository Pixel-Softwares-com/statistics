<?php

namespace Statistics\DateProcessors\DateProcessorTypes\GlobalDateProcessors;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;
use Statistics\DateProcessors\DateProcessorTypes\DateGroupedChartDateProcessors\DateGroupedChartDateProcessor;

class SemiAnnaulPeriodDateProcessor extends GlobalDateProcessor
{
    public function getStartingDateInstance(): Carbon
    {
        $date = Carbon::parseOrNow($this->getStartingDateRequestValue());
        $month = $date->month;

        return $month <= 6
            ? $date->startOfYear()->startOfMonth() // January 1
            : $date->startOfYear()->addMonths(6)->startOfMonth(); // July 1
    }
    public function getEndingDateInstance(): Carbon
    {
        $date = Carbon::parseOrNow($this->getStartingDateRequestValue());
        $month = $date->month;

        return $month <= 6
            ? $date->startOfYear()->addMonths(5)->endOfMonth() // June 30
            : $date->endOfYear()->endOfMonth(); // December 31
    }
}

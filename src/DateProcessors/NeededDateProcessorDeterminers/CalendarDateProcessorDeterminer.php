<?php

namespace Statistics\DateProcessors\NeededDateProcessorDeterminers;

use Statistics\DateProcessors\DateProcessor; 
use Statistics\DateProcessors\DateProcessorTypes\GlobalDateProcessors\RangePeriodDateProcessor; 

class CalendarDateProcessorDeterminer extends NeededDateProcessorDeterminer
{

    public function getDateProcessorInstance(): DateProcessor|null
    {
        return (match($this->getPeriodTypeRequestValue())
        {
            'all-time'       => null, /** for all time date filter (we don't want to set date filter) */
            default     => RangePeriodDateProcessor::Singleton($this::$request),

        });
    }
}

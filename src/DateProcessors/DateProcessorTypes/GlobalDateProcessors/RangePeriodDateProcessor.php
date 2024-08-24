<?php

namespace Statistics\DateProcessors\DateProcessorTypes\GlobalDateProcessors;

use Carbon\Carbon;

class RangePeriodDateProcessor extends GlobalDateProcessor
{

    public function getStartingDateInstance(): Carbon
    {
        return Carbon::parseOrNow($this->getStartingDateRequestValue())->startOfDay();
    }

    public function getEndingDateInstance(): Carbon
    {
        return Carbon::parseOrNow($this->getEndingDateRequestValue())->endOfDay();
    }
}

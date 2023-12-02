<?php

namespace Statistics\DateProcessors\DateProcessorTypes\GlobalDateProcessors;

use Carbon\Carbon;

class MonthPeriodDateProcessor extends GlobalDateProcessor
{
    public function getStartingDateInstance(): Carbon
    {
        return Carbon::parseOrNow($this->getStartingDateRequestValue())->startOfMonth();
    }

    public function getEndingDateInstance(): Carbon
    {
        return Carbon::parseOrNow($this->getStartingDateRequestValue())->endOfMonth();
    }
}

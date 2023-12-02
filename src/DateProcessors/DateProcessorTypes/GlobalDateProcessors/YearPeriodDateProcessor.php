<?php

namespace Statistics\DateProcessors\DateProcessorTypes\GlobalDateProcessors;

use Carbon\Carbon;

class YearPeriodDateProcessor extends GlobalDateProcessor
{
    protected static ?YearPeriodDateProcessor $instance = null;

    public function getStartingDateInstance(): Carbon
    {
        return Carbon::parseOrNow($this->getStartingDateRequestValue())->startOfYear();
    }

    public function getEndingDateInstance(): Carbon
    {
        return Carbon::parseOrNow($this->getStartingDateRequestValue())->endOfYear();
    }
}

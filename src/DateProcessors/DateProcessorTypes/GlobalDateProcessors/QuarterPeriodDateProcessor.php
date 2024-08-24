<?php

namespace Statistics\DateProcessors\DateProcessorTypes\GlobalDateProcessors;

use Carbon\Carbon;

class QuarterPeriodDateProcessor extends GlobalDateProcessor
{

    public function getStartingDateInstance(): Carbon
    {
        return Carbon::parseOrNow($this->getStartingDateRequestValue())->startOfQuarter();
    }

    public function getEndingDateInstance(): Carbon
    {
        return Carbon::parseOrNow($this->getStartingDateRequestValue())->endOfQuarter();
    }
}

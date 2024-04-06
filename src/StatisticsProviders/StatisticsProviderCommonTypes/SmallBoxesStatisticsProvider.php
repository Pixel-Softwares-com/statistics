<?php

namespace Statistics\StatisticsProviders\StatisticsProviderCommonTypes;

use Statistics\Interfaces\StatisticsProvidersInterfaces\NeedsAdditionalAdvancedOperations;
use Statistics\StatisticsProviders\CustomizableStatisticsProvider;

abstract class SmallBoxesStatisticsProvider extends CustomizableStatisticsProvider implements NeedsAdditionalAdvancedOperations
{
    public function getStatisticsTypeName(): string
    {
        return "smallBoxes";
    }
}

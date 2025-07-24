<?php

namespace Statistics\StatisticsProviders;

use Statistics\DataResources\DataResourceBuilders\GlobalDataResourceBuilder;

/**
 * This Class Is Only To Allow The Programmers to create new and empty types of StatisticsProvider (without default operations)
 * You Can Achieve that by inheritance
 */
abstract class CustomizableStatisticsProvider extends StatisticsProviderDecorator
{
    
    protected function getDataResourceBuildersOrdersByPriorityClasses(): array
    {
        return [
            GlobalDataResourceBuilder::class
        ];
    } 
}

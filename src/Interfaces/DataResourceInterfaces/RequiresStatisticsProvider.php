<?php

namespace Statistics\Interfaces\DataResourceInterfaces;

use Statistics\StatisticsProviders\StatisticsProviderDecorator;

interface RequiresStatisticsProvider
{
    public function setStatisticsProvider(StatisticsProviderDecorator $statisticsProvider);
    public function getStatisticsProvider() : StatisticsProviderDecorator;
}
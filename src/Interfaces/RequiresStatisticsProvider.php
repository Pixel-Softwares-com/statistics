<?php

namespace Statistics\Interfaces;

use Statistics\StatisticsProviders\StatisticsProviderDecorator;

interface RequiresStatisticsProvider
{
    public function setStatisticsProvider(StatisticsProviderDecorator $statisticsProvider);
    public function getStatisticsProvider() : StatisticsProviderDecorator;
}
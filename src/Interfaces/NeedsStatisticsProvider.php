<?php

namespace Statistics\Interfaces;

use Statistics\StatisticsProviders\StatisticsProviderDecorator;

interface NeedsStatisticsProvider
{
    public function setStatisticsProvider(StatisticsProviderDecorator $statisticsProvider);
    public function getStatisticsProvider() : StatisticsProviderDecorator;
}
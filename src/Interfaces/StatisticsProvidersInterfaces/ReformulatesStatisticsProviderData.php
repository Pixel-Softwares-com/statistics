<?php

namespace Statistics\Interfaces\StatisticsProvidersInterfaces;

interface ReformulatesStatisticsProviderData
{
    public function getReformulatableStatisticsProviderClass() : string;
    public function setReformulatableStatisticsProvider(HasReformulatableData $reformulatableStatisticsProvider) : void;
    public function getReformulatableStatisticsProvider() : HasReformulatableData;
}
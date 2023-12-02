<?php

namespace Statistics\QueryCustomizationStrategies\QueryCustomizationGlobalStrategies;


use Statistics\QueryCustomizationStrategies\QueryCustomizationStrategy;

class CountingQueryCustomizer extends QueryCustomizationStrategy
{

    protected function getOperationSqlString(string $column , string $alias) : string
    {
        return "count(" . $column . ") as " . $alias;
    }
}

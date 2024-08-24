<?php

namespace Statistics\QueryCustomizationStrategies\DateGroupedChartQueryCustomizers\DateGroupedChartSumQueryCustomizers;


class DaySumQueryCustomizer extends DateGroupedChartSumQueryCustomizer
{

    protected function getOperationSqlString(string $column, string $alias): string
    {
        $dateColumnName = $this->dateColumn->getColumnFullName();
        $dateColumnAlias = $this->dateColumn->getResultProcessingColumnAlias();
        return "sum(" . $column .") as " . $alias ." , concat( monthname(" . $dateColumnName .")  , '-' , day(" . $dateColumnName .") ) as " . $dateColumnAlias ;
    }
}

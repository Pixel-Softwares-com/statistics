<?php

namespace Statistics\QueryCustomizationStrategies\DateGroupedChartQueryCustomizers\DateGroupedChartAvgQueryCustomizers;

class DayAvgQueryCustomizer extends DateGroupedChartAvgQueryCustomizer
{

    protected function getOperationSqlString(string $column, string $alias): string
    {
        $dateColumnName = $this->dateColumn->getColumnFullName();
        $dateColumnAlias = $this->dateColumn->getResultProcessingColumnAlias();
        return "avg(" . $column .") as " . $alias ." , concat( monthname(" . $dateColumnName .")  , '-' , day(" . $dateColumnName .") ) as " . $dateColumnAlias ;
    }
}

<?php

namespace Statistics\QueryCustomizationStrategies\DateGroupedChartQueryCustomizers\DateGroupedChartCountQueryCustomizers;


class DayCountQueryCustomizer extends DateGroupedChartCountQueryCustomizer
{

    protected function getOperationSqlString(string $column, string $alias): string
    {
        $dateColumnName = $this->dateColumn->getColumnFullName();
        $dateColumnAlias = $this->dateColumn->getResultProcessingColumnAlias();
        return "count(" . $column .") as " . $alias ." , concat( monthname(" . $dateColumnName .")  , '-' , day(" . $dateColumnName .") ) as " . $dateColumnAlias ;
    }
}

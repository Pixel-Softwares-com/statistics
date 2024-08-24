<?php

namespace Statistics\QueryCustomizationStrategies\DateGroupedChartQueryCustomizers\DateGroupedChartCountQueryCustomizers;


class QuarterCountQueryCustomizer extends DateGroupedChartCountQueryCustomizer
{
    protected function getOperationSqlString(string $column, string $alias): string
    {
        $dateColumnName = $this->dateColumn->getColumnFullName();
        $dateColumnAlias = $this->dateColumn->getResultProcessingColumnAlias();
        return "count(" . $column .")  as " . $alias ." , concat( Year(" . $dateColumnName .") , '-Q' , QUARTER(" . $dateColumnName .") ) as " . $dateColumnAlias;
    }
}

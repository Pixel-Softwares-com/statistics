<?php
namespace Statistics\QueryCustomizationStrategies\DateGroupedChartQueryCustomizers;


class YearCountQueryCustomizer extends DateGroupedChartCountQueryCustomizer
{

    protected function getOperationSqlString(string $column, string $alias): string
    {
        $dateColumnName = $this->dateColumn->getColumnFullName();
        $dateColumnAlias = $this->dateColumn->getResultProcessingColumnAlias();
        return "count(" . $column .")  as " . $alias . " , year(" . $dateColumnName .") as " . $dateColumnAlias;
    }
}

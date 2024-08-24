# Statistics Structure - Usage
## StatisticsProvider Common Types
### BarAvgChartStatisticsProvider :
- This Provider is one of Date Grouped Chart Statistics Providers ,
  It contains some default statistical operations to do avg operation on the child class provided  aggregation column then grouping the  by date periods ,
  The result array will be wrapped in 'barAvgChart' named key.

-requirements to use :
- Implementing getModelClass method :
  To use this Provider you need to inherit it with a child Provider Class and implement this method to return a model class to using it in default operations .
- Implementing getAvgColumn method :
  implement this method in the child Provider Class to return an object of DataResourceInstructors\OperationComponents\Columns\AggregationColumn type to use it in Avg operation.

- Note : If you want to group the results by column other than 'created_at' database column ,
         The Model must Be Type Of App\CustomLibs\Statistics\Interfaces\ModelInterfaces\StatisticsProviderModel instance (Implements the interface).

For example - To get avg of all money paid in the date period coming from date filters and based on date period , We can use this code :

    <?php
    
    use Statistics\StatisticsProviders\StatisticsProviderCommonTypes\ChartStatisticsProviders\DateGroupedChartStatisticsProviders\BarAvgChartStatisticsProvider;
    use App\Models\WorkSector\Invoice;

    class InvoiceBarAvgChartStatisticsProvider extends BarAvgChartStatisticsProvider
    {
        public function getStatisticsProviderModelClass() : string
        {
            return Invoice::class;
        }
        protected function getAvgColumn() : AggregationColumn
        {
            /**
                Will sum all total values and the result key will be = Paied Money
            */
            return AggregationColumn::create("total")->setResultLabel("Paid Money");
        }
    }

# Statistics Structure - Usage
## StatisticsProvider Common Types
### BarSumChartStatisticsProvider :
- This Provider is one of Date Grouped Chart Statistics Providers ,
  It contains some default statistical operations to do sum operation on the child class provided  aggregation column then grouping the  by date periods ,
  The result array will be wrapped in 'barSumChart' named key.

-requirements to use :
- Implementing getModelClass method :
  To use this Provider you need to inherit it with a child Provider Class and implement this method to return a model class to using it in default operations .
- Implementing getSumColumn method :
  implement this method in the child Provider Class to return an object of DataResourceInstructors\OperationComponents\Columns\AggregationColumn type to use it in sum operation.

- Note : If you want to group the results by column other than 'created_at' database column ,
         The Model must Be Type Of App\CustomLibs\Statistics\Interfaces\ModelInterfaces\StatisticsProviderModel instance (Implements the interface).

For example - To get sum of all money paid in the date period coming from date filters and based on date period , We can use this code :

    <?php
    
    use Statistics\StatisticsProviders\StatisticsProviderCommonTypes\ChartStatisticsProviders\DateGroupedChartStatisticsProviders\BarSumChartStatisticsProvider;
    use App\Models\WorkSector\Invoice;

    class InvoiceBarSumChartStatisticsProvider extends BarSumChartStatisticsProvider
    {
        public function getStatisticsProviderModelClass() : string
        {
            return Invoice::class;
        }
        protected function getSumColumn() : AggregationColumn
        {
            /**
                Will sum all total values and the result key will be = Paied Money
            */
            return AggregationColumn::create("total")->setResultLabel("Paid Money");
        }
    }

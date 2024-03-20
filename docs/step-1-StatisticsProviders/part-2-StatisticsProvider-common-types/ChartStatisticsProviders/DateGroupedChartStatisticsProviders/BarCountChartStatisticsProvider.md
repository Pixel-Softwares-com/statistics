# Statistics Structure - Usage
## StatisticsProvider Common Types
### BarCountChartStatisticsProvider :
- This Provider is one of Date Grouped Chart Statistics Providers , It contains some default statistical operations to do some counting operations on the column grouped by date periods ,
  The result array will be wrapped in 'barChart' named key.

-requirements to use :
- Implementing getModelClass method :
  To use this Provider you need to inherit it with a child Provider Class and implement this method to return a model class to using it in default operations .

- Note : Model must Be Type Of App\CustomLibs\Statistics\Interfaces\ModelInterfaces\StatisticsProviderModel instance (Implements the interface).

For example - To getting count of all clients added in the date period coming from date filters and based on date period , We can use this code :

    <?php
    
    use Statistics\StatisticsProviders\StatisticsProviderCommonTypes\ChartStatisticsProviders\DateGroupedChartStatisticsProviders\BarCountChartStatisticsProvider;
    use App\Models\WorkSector\Client;

    class ClientBarCountChartStatisticsProvider extends BarCountChartStatisticsProvider
    {
        public function getStatisticsProviderModelClass() : string
        {
            return Client::class;
        }
    }

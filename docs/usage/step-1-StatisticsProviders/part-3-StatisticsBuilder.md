# Statistics Structure - Usage
##  Statistics Builder :

- It is used to wrap many StatisticsProvider's result arrays in a big array , 
  It is easier to use when you need to call too much StatisticsProvider and wrap its values in one array to respond ,
  It gets benefit from Decorator design pattern that StatisticsProvider built on .

### Requirements to use it :

- Creating a StatisticsBuilderBaseService child class :
create a class inherits from  App\CustomLibs\Statistics\StatisticsBuilderBaseService Builder class.
- Implement the abstract method 'getStatisticsProviderTypeClasses' :
  Must return an array of desired StatisticsProvider type classes to initialize them and wrap them inside each other.
- Getting Statistics result : 
  Use getStatistics public method to get the statistics data array
- You may want to hold the providers and StatisticsBuilder classes in one directory to make them more organized .

For Example - using ClientSmallBoxesStatisticsProvider & ClientBigBoxStatisticsProvider & ClientPieChartStatisticsProvider & ClientBarChartStatisticsProvider together in the same request :

    <?php
 
    use App\CustomLibs\Statistics\StatisticsBuilderBaseService\StatisticsBuilderBaseService;
    
    class ClientStatisticsBuilder extends StatisticsBuilderBaseService
    {
        protected function getStatisticsProviderTypeClasses(): array
        {
            return [
                ClientSmallBoxesStatisticsProvider::class ,
                ClientBigBoxStatisticsProvider::class,
                ClientPieChartStatisticsProvider::class,
                ClientBarChartStatisticsProvider::class
            ];
        }
    }
# Statistics Structure - Usage

##  Statistics Builder :

- It is used to wrap many StatisticsProvider's result arrays in a big array , it is easier to use when you need to call too much StatisticsProvider and wrap its values in one array to respond ,
It gets benefit from Decorator design pattern that StatisticsProvider built on .

### to use it :

- create a class inherits from  App\CustomLibs\Statistics\StatisticsBuilderBaseService Builder class.
- implement the abstract methods :
    * getStatisticsProviderTypeClasses : must return an array of desired StatisticsProvider types to initialize them and wrap them inside each other (array of the newly created child classes of StatisticsProvider class ) .
- use getStatistics public method to get the statistics data array
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

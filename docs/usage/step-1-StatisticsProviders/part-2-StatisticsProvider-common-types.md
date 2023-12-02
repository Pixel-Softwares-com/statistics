# Statistics Structure - Usage

## StatisticsProviders - Common Types
- ChartStatisticsProviders :
  - BarChartStatisticsProvider .
  - PieChartStatisticsProvider .
- BigBoxStatisticsProvider .
- SmallBoxesStatisticsProvider .

### BarChartStatisticsProvider : 
- This Provider is one of ChartStatisticsProviders StatisticsProviders , It contains some default statistical operations to do some counting operations on the column grouped by date periods ,
    The result array will be wrapped in 'barChart' named key.

- To use this Provider you need to inherit it with a child Provider Class and implement this method "getStatisticsProviderModelClass" to return a model class to using it in default operations .

- Note : Model must Be Type Of App\CustomLibs\Statistics\Interfaces\ModelInterfaces\StatisticsProviderModel instance (Implements the interface).

For example - To getting count of all clients added in the date period coming from date filters and based on date period , We can use this code :

    <?php
    
    use App\CustomLibs\Statistics\StatisticsProviders\StatisticsProviderCommonTypes\ChartStatisticsProviders\BarChartStatisticsProvider;
    use App\Models\WorkSector\Client;

    class ClientBarChartStatisticsProvider extends BarChartStatisticsProvider
    {
        public function getStatisticsProviderModelClass() : string
        {
            return Client::class;
        }
    }

<hr>

### PieChartStatisticsProvider : 
- This Provider is one of ChartStatisticsProviders StatisticsProviders , It (( Doesn't )) contain (( ANY )) default statistical operations because it is inherited from CustomizableStatisticsProvider StatisticsProvider ,
    and implements App\CustomLibs\Statistics\Interfaces\StatisticsProvidersInterfaces\NeedsAdditionalAdvancedOperations interface  , so it expect to receive the desired statistical operations from the child classes will be inherited from  itself by implementing "getAdditionalAdvancedOperations" method.
- The differance between it and the other providers is that this provider process the result data to show it as percentage values ( (value / totalValues percentage) ) and you don't need to worry about them.
- The result array will be wrapped in 'pieChart' named key.

For example - To getting count of all clients added in the date period coming from date filters based on their country ,  we can use this code :

    <?php
    
        use App\CustomLibs\Statistics\StatisticsProviders\StatisticsProviderCommonTypes\ChartStatisticsProviders\PieChartStatisticsProvider;
        use App\Models\WorkSector\Client;
        use App\CustomLibs\Statistics\OperationsManagement\Operations\OperationContainers\OperationGroups\OperationGroup;

        class ClientPieChartStatisticsProvider extends PieChartStatisticsProvider
        {
            protected function getCountingClientGroupedByCountryOperationGroup() : OperationGroup
            {
                return OperationGroup::create( /*.....etc of params*/) ;
            }
            public function getAdditionalAdvancedOperations(): array
            {
                return [ 
                            $this->getCountingClientGroupedByCountryOperationGroup() /*getting clients count grouped by country and processing result values to make it percentage values */ 
                       ]; /*Array Of OperationGroup objects */
            }
        }

<hr>

### BigBoxStatisticsProvider : 
- It (( Doesn't )) contain (( ANY )) default statistical operations because it is inherited from CustomizableStatisticsProvider StatisticsProvider ,
    and implements App\CustomLibs\Statistics\Interfaces\StatisticsProvidersInterfaces\NeedsAdditionalAdvancedOperations interface  , so it expect to receive the desired statistical operations from the child classes will be inherited from  itself by implementing "getAdditionalAdvancedOperations" method.
- There are no differance between it and the other providers, but it is a provider for a common statistics used in Pixel company software ( named 'total' ) .
- The result array will be wrapped in 'total' named key ... so use it when you need to wrap some operation results in 'total' key and feel free to request any operations you need.

For example - To getting count of all clients added in the date period coming from date filters based on their status ,  we can use this code :

    <?php
    
        use App\CustomLibs\Statistics\StatisticsProviders\StatisticsProviderCommonTypes\BigBoxStatisticsProvider;
        use App\Models\WorkSector\Client;
        use App\CustomLibs\Statistics\OperationsManagement\Operations\OperationContainers\OperationGroups\OperationGroup;

        class ClientBigBoxStatisticsProvider extends BigBoxStatisticsProvider
        {
            protected function getCountingClientGroupedByStatusOperationGroup() : OperationGroup
            {
                return OperationGroup::create( /*.....etc of params*/) ;
            }
            public function getAdditionalAdvancedOperations(): array
            {
                return [
                    $this->getCountingClientGroupedByStatusOperationGroup()
                ]; /*Array Of OperationGroup objects */
            }
        }

<hr>

### SmallBoxesStatisticsProvider : 
- It (( Doesn't )) contain (( ANY )) default statistical operations because it is inherited from CustomizableStatisticsProvider StatisticsProvider ,
    and implements App\CustomLibs\Statistics\Interfaces\StatisticsProvidersInterfaces\NeedsAdditionalAdvancedOperations interface  , so it expect to receive the desired statistical operations from the child classes will be inherited from  itself by implementing "getAdditionalAdvancedOperations" method.
- There are no differance between it and the other providers, but it is a provider for a common statistics used in Pixel company software ( named 'smallBoxes' ) and there are some common operation factories made for this statisticsProvider type to make using it more easy and fast (look at the common operations - operationsManagement docs part) .
- The result array will be wrapped in 'smallBoxes' named key ... so use it when you need to wrap some operation results in 'smallBoxes' key and feel free to request any operations you need or using the common operation factories to help you.


For example -  To request two counting operations :

- getting count of all clients added in the date period coming from date filters (date range)  .
- getting count of all clients added from the first operating time until date coming from date filters ( past - until the given date ).

We can use this code :

    <?php
    
        use App\CustomLibs\Statistics\StatisticsProviders\StatisticsProviderCommonTypes\SmallBoxesStatisticsProvider;
        use App\Models\WorkSector\Client;
        use App\CustomLibs\Statistics\OperationsManagement\Operations\OperationContainers\OperationGroups\OperationGroup;

        class ClientSmallBoxesStatisticsProvider extends SmallBoxesStatisticsProvider
        {
            protected function getAddedClientInDateRangeOperationGroup() : OperationGroup
            {
                return (new CountingAddedInDateRangeOperationFactory())->setTableName("tableName")->make();
            }
            protected function getAllClientOperationGroup() : OperationGroup
            {
                return (new CountingAllRowsUntilEndDateOperationFactory($this->dateProcessor))->setTableName("tableName")->make();
            }
            public function getAdditionalAdvancedOperations(): array
            {
                return [
                    $this->getAddedClientInDateRangeOperationGroup(),
                    $this->getAllClientOperationGroup()
                ]; /*Array Of OperationGroup objects */
            }
        }

<hr>

###  Statistics Builder Using :

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

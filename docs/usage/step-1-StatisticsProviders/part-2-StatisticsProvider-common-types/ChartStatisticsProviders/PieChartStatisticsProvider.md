# Statistics Structure - Usage
## StatisticsProvider Common Types
### PieChartStatisticsProvider :
- This Provider is one of ChartStatisticsProviders StatisticsProviders .
- Requirements to use :
  Implementing getAdditionalAdvancedOperations method :
  This Provider (( Doesn't )) contain (( ANY )) default statistical operations because it is inherited from CustomizableStatisticsProvider StatisticsProvider ,
  and implements App\CustomLibs\Statistics\Interfaces\StatisticsProvidersInterfaces\NeedsAdditionalAdvancedOperations interface  ,
  so it expects to receive the desired statistical operations from the child classes will be inherited from  itself .

- It expects an array of DataResourceInstructors\OperationContainers\OperationGroups\OperationGroup objects  (Look at OperationManagement docs part ) ,
So Compose those OperationGroups as you like ,
  And return them from the method NeedsAdditionalAdvancedOperations interface requires ,
  and the result array will be wrapped in 'pieChart' named key .

- The differance between it and the other providers is that this provider process the result data to show it as percentage values ( (value / totalValues percentage) ) ,
  and you don't need to worry about them.
- The result array will be wrapped in 'pieChart' named key.

For example - To getting count of all clients added in the date period coming from date filters based on their country ,  we can use this code :

    <?php

        use Statistics\StatisticsProviders\StatisticsProviderCommonTypes\ChartStatisticsProviders\PieChartStatisticsProvider;
        use App\Models\WorkSector\Client;
        use DataResourceInstructors\OperationContainers\OperationGroups\OperationGroup;

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

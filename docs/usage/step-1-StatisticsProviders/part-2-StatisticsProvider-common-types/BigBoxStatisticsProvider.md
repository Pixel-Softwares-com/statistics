# Statistics Structure - Usage
## StatisticsProvider Common Types
### BigBoxStatisticsProvider :
- There are no differance between it and the other providers,
  But it is a provider for a common statistics used in Pixel company software ( named 'total' ) .

-Requirements to use :
Implementing getAdditionalAdvancedOperations method :
- This provider (( Doesn't )) contain (( ANY )) default statistical operations because it is inherited from CustomizableStatisticsProvider StatisticsProvider ,
  And implements App\CustomLibs\Statistics\Interfaces\StatisticsProvidersInterfaces\NeedsAdditionalAdvancedOperations interface  ,
  So it expects to receive the desired statistical operations from the child classes will be inherited from  itself .
- It expects an array of DataResourceInstructors\OperationContainers\OperationGroups\OperationGroup objects  (Look at OperationManagement docs part ) ,
So Compose those OperationGroups as you like , 
And return them from the method NeedsAdditionalAdvancedOperations interface requires ,
and the result array will be wrapped in 'total' named key .

- The result array will be wrapped in 'total' named key ,
  So use it when you need to wrap some operation results in 'total' key and feel free to request any operations you need.

For example - To getting count of all clients added in the date period coming from date filters based on their status ,  we can use this code :

    <?php
    
        use Statistics\StatisticsProviders\StatisticsProviderCommonTypes\BigBoxStatisticsProvider;
        use App\Models\WorkSector\Client;
        use DataResourceInstructors\OperationContainers\OperationGroups\OperationGroup;

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

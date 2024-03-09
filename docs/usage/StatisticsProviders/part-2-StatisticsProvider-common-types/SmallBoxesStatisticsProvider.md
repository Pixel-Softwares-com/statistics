# Statistics Structure - Usage
## StatisticsProvider Common Types
### SmallBoxesStatisticsProvider :
- There are no differance between it and the other providers,
  But it is a provider for a common statistics used in Pixel company software ( named 'smallBoxes' ) ,
  And there are some common operation factories made for this statisticsProvider type to make using it more easy and fast (look at the common operations - operationsManagement docs part) .

-Requirements to use :
Implementing getAdditionalAdvancedOperations method :
- This provider (( Doesn't )) contain (( ANY )) default statistical operations because it is inherited from CustomizableStatisticsProvider StatisticsProvider ,
  and implements App\CustomLibs\Statistics\Interfaces\StatisticsProvidersInterfaces\NeedsAdditionalAdvancedOperations interface  ,
  So it expect to receive the desired statistical operations from the child classes will be inherited from  itself .
- The result array will be wrapped in 'smallBoxes' named key ,
  So use it when you need to wrap some operation results in 'smallBoxes' key and feel free to request any operations you need or using the common operation factories to help you.


For example -  To request two counting operations :

- getting count of all clients added in the date period coming from date filters (date range)  .
- getting count of all clients added from the first operating time until date coming from date filters ( past - until the given date ).

We can use this code :

    <?php
    
        use Statistics\StatisticsProviders\StatisticsProviderCommonTypes\SmallBoxesStatisticsProvider;
        use App\Models\WorkSector\Client;
        use DataResourceInstructors\OperationContainers\OperationGroups\OperationGroup;

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

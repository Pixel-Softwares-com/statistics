# Statistics Structure - Usage
## OperationsManagement

### Common operations factories : 
  - They are used to encapsulate some high used and common operations to make the work faster and easier .
  - Any of these classes must be inherited from CommonOperationFactory and implements its 'make' method
    to return an OperationGroup instance that can be used to instruct the StatisticsProvider to do some statistical operations.
  - There are some common operations in this structure ,
    But you can creat other types as you need by inheriting the Statistics\OperationsManagement\Operations\CommonOperationFactories\CommonOperationFactory class.

#### CommonOperationFactories public methods :

##### public function make() : OperationGroup
makes and returns an OperationGroup instance that can be used to instruct the ServiceProvider which statistical operation must do .

##### public function forModel(string | Model $modelClass) : CommonOperationFactory
Optional method to set Model class or object (if required by the CommonOperationFactory child class you use).

##### public function setModel( Model $model): void
Optional method to set only Model object (if required by the CommonOperationFactory child class you use).

##### public function setDateColumn(?Column $dateColumn): CommonOperationFactory
- Optional method to set Date column object .
- The factory will use getDateColumnConveniently method when it needs to handle date conditions.  
    
##### public function getDateColumnConveniently(): Column
- Gets the DateColumn will be used by the factory in date conditions .
- By default , it will check if you have been set the DateColumn before 
  else it will check the model exists and implements StatisticsProviderModel interface
  it will use the model's getStatisticDateColumnName method otherwise it will use 'created_at' column name
  So use it when you want to change date column for the returned OperationGroup .

##### public function setCountedKeyName(string $countedKeyName): CommonOperationFactory
- Optional method to set the table column will be counted .
- By default , the factory uses the key name you set , else it will check for model key name , otherwise it will use 'id' column name.

#####  public function setTableName(string $tableName): CommonOperationFactory
- Optional method to set the table name will be used .
- if no tableName is set it will check for the model tableName ... otherwise an Exception will be thrown .

##### public function setAggregationColumnResultLabel(string $labelString) : CommonOperationFactory
- Optional method to change the counted column value's label .
- If it is not changed it will be changed by the child factory class .

##### public function getAggregationResultLabel(): string
- Optional method to get the counted column value's label you've been set.



#### Statistics structure's ready CommonOperationFactories class :
##### CountingGroupByColumnOperationFactory : 
- It is used faking an OperationGroup for doing counting operation on the table key column with date condition on the defined Date Column 
And grouping the results on the GroupingByColumn that passed to its constructor .
- If the 'AggregationResultLabel' hasn't been changed  , It will use GroupingByColumn 's getResultProcessingColumnAlias method to set the counting operation value result label .

##### CountingAllRowsUntilEndDateOperationFactory
- CountingAddedInDateRangeOperationFactory

  Each of these factories returns an OperationGroup instance when 'make' method is called ,
  So use the public methods above to change the OperationGroup faking behaviors ,
  And feel free to set another properties you want on the result OperationGroup to make your work custom as you need .
  

  Example : This code is used to getting count of all clients added in the date period coming from date filters based on their status .

        <?php
       
                 use App\CustomLibs\Statistics\StatisticsProviders\StatisticsProviderCommonTypes\BigBoxStatisticsProvider;
                 use App\Models\WorkSector\Client;
                 use App\CustomLibs\Statistics\OperationsManagement\Operations\OperationContainers\OperationGroups\OperationGroup;
       
                 class ClientBigBoxStatisticsProvider extends BigBoxStatisticsProvider
                 {
                     protected function getCountingClientGroupedByStatusOperationGroup() : OperationGroup
                     {
                         $groupingColumn = GroupingByColumn::create("status" , "status");
                         return (new CountingGroupByColumnOperationFactory($groupingColumn))->setTableName("tableName")->make();
                     }
                     public function getAdditionalAdvancedOperations(): array
                     {
                         return [
                             $this->getCountingClientGroupedByStatusOperationGroup()
                         ]; /*Array Of OperationGroup objects */
                     }
                 }


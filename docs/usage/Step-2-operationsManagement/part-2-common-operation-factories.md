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

##### CountingAddedInDateRangeOperationFactory
It is used to make an OperationGroup for :
- Doing counting operation on the table key column (by default 'id') .
- Enabling date condition on the defined Date Column (by default 'created_at') : between start -> end date values those come from request filters .


##### CountingGroupByColumnOperationFactory : 
- It does what CountingAddedInDateRangeOperationFactory does +  Grouping the results on the GroupingByColumn that passed to its constructor .

Note :If the 'AggregationResultLabel' hasn't been changed  ,
It will use GroupingByColumn 's getResultProcessingColumnAlias method to set the counting operation value result label .

##### CountingAllRowsUntilEndDateOperationFactory
It is used to make an OperationGroup for :
- Doing counting operation on the table key column (by default 'id') .
- Setting date condition on the defined Date Column (by default 'created_at') : all rows before until the end date value that comes from request filters .


  Each of these factories returns an OperationGroup instance when 'make' method is called ,
  So use the public methods above to change the OperationGroup making behaviors before calling make method,
  And feel free to set another properties you want on the result OperationGroup to make your work custom as you need .

Example : This code is used to getting count of all clients added in the date range coming from date filters .

        <?php
       
                 use Statistics\StatisticsProviders\StatisticsProviderCommonTypes\BigBoxStatisticsProvider;
                 use Statistics\OperationsManagement\Operations\CommonOperationFactories\CountingAddedInDateRangeOperationFactory;
                 use App\Models\WorkSector\Client;
                 use DataResourceInstructors\OperationContainers\OperationGroups\OperationGroup;
       
                 class ClientBigBoxStatisticsProvider extends BigBoxStatisticsProvider
                 {
                     protected function getCountingClientOperationGroup() : OperationGroup
                     {
                        /** getting all added clients count between start - end date request filter values */
                         return (new CountingAddedInDateRangeOperationFactory())->setTableName("clients_table_name")->make();
                     }
                     public function getAdditionalAdvancedOperations(): array
                     {
                         return [
                             $this->getCountingClientOperationGroup()
                         ]; /*Array Of OperationGroup objects */
                     }
                 }

  Example : This code is used to getting count of all clients added in the date range coming from date filters
            based on their status (grouping results on status column value).

        <?php
       
                 use Statistics\StatisticsProviders\StatisticsProviderCommonTypes\BigBoxStatisticsProvider;
                 use Statistics\OperationsManagement\Operations\CommonOperationFactories\CountingGroupByColumnOperationFactory;
                 use App\Models\WorkSector\Client;
                 use DataResourceInstructors\OperationComponents\Columns\GroupingByColumn;
                 use DataResourceInstructors\OperationContainers\OperationGroups\OperationGroup;
       
                 class ClientBigBoxStatisticsProvider extends BigBoxStatisticsProvider
                 {
                     protected function getCountingClientGroupedByStatusOperationGroup() : OperationGroup
                     {
                        /** 
                            getting all added clients count between start - end date request filter values 
                            and grouping the results on status value
                        */
                         $groupingColumn = GroupingByColumn::create("status" , "status");
                         return (new CountingGroupByColumnOperationFactory($groupingColumn))->setTableName("clients_table_name")->make();
                     }
                     public function getAdditionalAdvancedOperations(): array
                     {
                         return [
                             $this->getCountingClientGroupedByStatusOperationGroup()
                         ]; /*Array Of OperationGroup objects */
                     }
                 }



Example : This code is used to getting count of all clients added in the database until the end date coming from date filters .

        <?php
       
                 use Statistics\StatisticsProviders\StatisticsProviderCommonTypes\BigBoxStatisticsProvider;
                 use Statistics\OperationsManagement\Operations\CommonOperationFactories\CountingAllRowsUntilEndDateOperationFactory;
                 use App\Models\WorkSector\Client;
                 use DataResourceInstructors\OperationContainers\OperationGroups\OperationGroup;
       
                 class ClientBigBoxStatisticsProvider extends BigBoxStatisticsProvider
                 {
                     protected function getCountingClientUntilEndDateOperationGroup() : OperationGroup
                     {
                         return (new CountingAllRowsUntilEndDateOperationFactory())->setTableName("clients_table_name")->make();
                     }
                     public function getAdditionalAdvancedOperations(): array
                     {
                         return [
                             $this->getCountingClientUntilEndDateOperationGroup()
                         ]; /*Array Of OperationGroup objects */
                     }
                 }


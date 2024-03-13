# Statistics Structure - Usage
## OperationsManagement - Operation Components

<hr>

### Operation Components :
- There are two main types of these components :  
 
  - Columns & Conditions & Ordering : They are the easiest way to set OperationContainers and AggregationOperations properties without making any validation that will make the processing slower ,
    Example : When you need to group by a column or order by it , you may use Column typed object to instruct the OperationContainer which column must it use , 
    like in this code which is used to getting count of all clients added in the date period coming from date filters based on their status .

           <?php
    
              use App\CustomLibs\Statistics\StatisticsProviders\StatisticsProviderCommonTypes\BigBoxStatisticsProvider;
              use App\CustomLibs\Statistics\OperationsManagement\Operations\OperationComponents\Columns\GroupingByColumn;
              use App\CustomLibs\Statistics\OperationsManagement\Operations\OperationContainers\OperationGroups\OperationGroup;
    
              class ClientBigBoxStatisticsProvider extends BigBoxStatisticsProvider
              {
                  protected function getCountingClientGroupedByStatusOperationGroup() : OperationGroup
                  {
                      $groupingColumn = GroupingByColumn::create("status" , "status");
                      return OperationGroup::create( /*.....etc of params*/)->groupedByColumn($groupingColumn) ;
                  }
                  public function getAdditionalAdvancedOperations(): array
                  {
                      return [
                          $this->getCountingClientGroupedByStatusOperationGroup()
                      ]; /*Array Of OperationGroup objects */
                  }
              }

<hr>

### Usage Steps :
- No rules , use Create static public method to create the component and use it what you need .    
- You can create a condition or column and use it to instruct the OperationContainers ,
Or you can request common operation factories to make an instance of a common used OperationContainer to make you work faster and easier . 

<hr>

### Columns : 
- It contains the basic properties of any column in database (name , tableName , alias )  ,
  used when you need to instruct the OperationContainer to use a database column in grouping or ordering or doing aggregation operation or even using it in a condition or join ,
So it is the most important component and without it there is no operations or query will be executed .
- you must set the name manually .
- You must not set the tableName because it will be set automatically .
- You may need to set alias of column ( like in GroupingByColumn because it is used in result data processing operations ) .

#### Column Types :
- Column : it is not an abstract class or interface , But it is the base of all other columns .
    - you can initialize it by 'create' static method or even by its  __construct()
    - Example :
  
            Column::create("status") /* where status is the column name in database */ 
            or 
            (new Column("status")) /* where status is the column name in database */
  
    - you may use 'setResultProcessingColumnAlias' public method to set the column's alias used in data processing .
      
            Column::create("status")->setResultProcessingColumnAlias("Client_Status") /* where status is the column name in database */
    - 
    - You may need to use this Column type in OperationContainer::orderBy or OperationGroup::enableDateSensitivity 
      ( or anywhere you need a column object has the basic props and methods without any extra functionality).

- AggregationColumn : It is required to instruct the Operation object which column must be used in aggregation operation ,
  It is inherited from Column class ... So you can use Column class methods.

  - The Column's Alias will automatically be set if you don't chang it (It is not necessary to set it yourself because you will not use it manually in any situation ) .
  - As an extra functionality it contains 'setResultLabel' method which allow you to set the label of this aggregation operation's result done on this column ,
    It accepts a string value , And if you instructed the OperationGroup to group the rows by some column you can use that column alias prefixed with ":" (look at the example bellow ).
  
  - Example : this code is used to getting count of clients added in the date period coming from date filters 
   (by counting clients table 's id column & grouped by its status)  ,
    and as you can see we used the grouped by column 's alias with ":" prefix in the Result Label of the aggregation column to using column value (coming from database) in the result keys.

          <?php

                use App\CustomLibs\Statistics\StatisticsProviders\StatisticsProviderCommonTypes\BigBoxStatisticsProvider;
                use App\CustomLibs\Statistics\OperationsManagement\Operations\OperationComponents\Columns\AggregationColumn;
                use App\CustomLibs\Statistics\OperationsManagement\Operations\OperationComponents\Columns\GroupingByColumn;
                use App\CustomLibs\Statistics\OperationsManagement\Operations\OperationTypes\CountOperation;
                use App\CustomLibs\Statistics\OperationsManagement\Operations\OperationContainers\OperationGroups\OperationGroup;

                class ClientBigBoxStatisticsProvider extends BigBoxStatisticsProvider
                {
                    protected function getCountingClientGroupedByStatusOperationGroup() : OperationGroup
                    {
                        $groupingColumn = GroupingByColumn::create("status" , "status");
                        $idColumn = AggregationColumn::create("id" )->setResultLabel("Count of :status Clients");
                        $countOperation = CountOperation::create()->addAggregationColumn($idColumn);
                        return OperationGroup::create("clients")->addOperation($countOperation)->groupedByColumn($groupingColumn) ; ;
                    }
                    public function getAdditionalAdvancedOperations(): array
                    {
                        return [
                            $this->getCountingClientGroupedByStatusOperationGroup()
                        ]; /*Array Of OperationGroup objects */
                    }
                }
    The output will be :

        [
          "Count of Active Clients" => 4 /* 4 active clients for example */ ,
          "Count of inactive Clients" => 2 /* 2 inactive clients for example */ ,
        ]

    - We will talk more clearly about using Operation types in its docs part.

  - GroupingByColumn : It is required for instructing OperationContainer to group the data row on a column , it is inherited from Column ,
    but also it require you to set the column's alias in 'constructor' or 'create' as a second parameter 
    (also you can change it later by 'setResultProcessingColumnAlias' method ) .
  - Example :

           GroupingByColumn::create("status" , "statusColumnAlias") /* where status is the column name in database */ 
           or 
           (new GroupingByColumn("status" , "statusColumnAlias")) /* where status is the column name in database */
    - As an extra functionality it contains 'setProcessingRequiredForStaticValues' method 
      which allow you to pass the column's required values to the DataProcessor to instruct it that these values must be in the final result array 
      even if it doesn't exist in any database row (in this situation it will fill them by 0 ) .
      Note : Make sure to use it for the only static values (which they are a few values , and  easy to process by DataProcessor ,
      It can process any set of values but because of the statistics structure used in RunTime request we must take care about the time and resources used in processing ).

  - Example : In the previous example above , We added setProcessingRequiredForStaticValues method to instruct the DataProcessor which status values must be found in final result array and take care about them in data processing . 

           <?php

                 use App\CustomLibs\Statistics\StatisticsProviders\StatisticsProviderCommonTypes\BigBoxStatisticsProvider;
                 use App\CustomLibs\Statistics\OperationsManagement\Operations\OperationComponents\Columns\AggregationColumn;
                 use App\CustomLibs\Statistics\OperationsManagement\Operations\OperationComponents\Columns\GroupingByColumn;
                 use App\CustomLibs\Statistics\OperationsManagement\Operations\OperationTypes\CountOperation;
                 use App\CustomLibs\Statistics\OperationsManagement\Operations\OperationContainers\OperationGroups\OperationGroup;

                 class ClientBigBoxStatisticsProvider extends BigBoxStatisticsProvider
                 {
                     protected function getCountingClientGroupedByStatusOperationGroup() : OperationGroup
                     {
                         $groupingColumn = GroupingByColumn::create("status" , "status")->setProcessingRequiredForStaticValues("active" , "inactive");
                         $idColumn = AggregationColumn::create("id" )->setResultLabel("Count of :status Clients");
                         $countOperation = CountOperation::create()->addAggregationColumn($idColumn);
                         return OperationGroup::create("clients")->addOperation($countOperation)->groupedByColumn($groupingColumn) ; ;
                     }
                     public function getAdditionalAdvancedOperations(): array
                     {
                         return [
                             $this->getCountingClientGroupedByStatusOperationGroup()
                         ]; /*Array Of OperationGroup objects */
                     }
                 }
    Let us consume that there are no inactive clients in clients table , The output will be :

             [
               "Count of Active Clients" => 4 /* 4 active clients in table (for example )*/ ,
               "Count of inactive Clients" => 0 /* 0 inactive clients because it is a required to process value even if it is not exist in table */ ,
             ]

### Conditions
### Ordering
### Common Operations Factories 

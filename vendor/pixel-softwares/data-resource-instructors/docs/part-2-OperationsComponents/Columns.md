# DataResourceInstructors Structure
### Operation Components - Columns : 
- It contains the basic properties of any column in database (name , tableName , alias )  ,
  use it when you need to determine the column must the OperationContainer or AggregationOperation (or even other Components like conditions) use in their operations .
- you must set the name manually .
- You must not set the tableName because it will be set automatically while adding it to the component will use (OperationContainer , .. etc.).
- You may need to set alias of column ( like in GroupingByColumn because it is used in result data processing operations ) .

### Column Types :
#### Column : it is not an abstract class or interface , But it is the base of all other columns .
You may need to use this Column type in OperationContainer::orderBy or OperationGroup::enableDateSensitivity 
( or anywhere you need a column object has the basic props and methods without any extra functionality).

- methods :
  - __construct(string $columnName)  : Creates a new instance of the Column class.
  - Column::create(string $columnName) :  Creates a new instance of the Column class.  
      - Example :
  
              Column::create("status") /* where status is the column name in database */ 
              or 
              (new Column("status")) /* where status is the column name in database */
    
  - setResultProcessingColumnAlias : to set the column's alias used in data processing .
      - Example : 
                Column::create("status")->setResultProcessingColumnAlias("Client_Status") /* where status is the column name in database */
  - getResultProcessingColumnAlias(): Gets the column's alias used in data processing .
  - getTableName(): Gets the name of the table.
  - setTableName(string $tableName): Sets the name of the table.
  - getColumnName(): Gets the name of the column.
  - getColumnFullName(): Gets the full name of the column including table name.
  
#### AggregationColumn : It is required to instruct the AggregationOperation object which column must be used in aggregation operation .
- It is Column typed class ( inherited from Column class) ... So you can use Column class methods.
- The Column's Alias will automatically be set if you don't chang it 
(It is not necessary to set it yourself because you will not use it manually in any situation ) .

- extra methods :
    - setResultLabel(string $resultLabel) : 
      allow you to set the label of this aggregation operation's result done on this column ,
      It accepts a string value , And if you instructed the OperationGroup to group the rows by some column
      you can use that column alias prefixed with ":" (look at the example bellow ).
    - getResultLabel() : Gets the label of this aggregation operation's result done on this column .
    - setResultLabelMaxLength(int $length , string $shortLabel) :
      set max character length that must be applied on the column final result label (after data processing) ,
      it takes as the length integer value the first parameter , and the alternative result label will be applied if the primary result label is longer than the length value .
      - Notes to use in DataResource :
            - The alternative result label must also be processed to replace the grouping column colon prefixed aliases with their values exists in the data array .
            - If the both primary and the alternative result label are longer than the length value ... the alternative result label must be sliced with character length equal to length parameter value .  
    - getAlternativeShortResultLabel() : Gets the alternative result label (if it is not set by setResultLabelMaxLength method by default gets an empty string ) .
    - getResultLabelMaxLength() : Gets the length must limit the column result labels (if it is not set by setResultLabelMaxLength method by default gets -1 integer value .)
    - isCharLengthLimited() : Gets boolean value , true if there is a limit on resultLabel character length  ,false it there is not a limit . 
    - disableLimitingResultLabelCharLength() : To disable applying any result label character length limiting .

- Example : this code is used to getting count of clients added in the date period coming from date filters 
 (by counting clients table 's id column & grouped by its status)  ,
  And as you can see we set the result label of counting resul done on the aggregation column = "Count of :status Clients" 
  to using status column value (coming from database) in the result label (look to the output part).

        <?php

              use Statistics\StatisticsProviders\StatisticsProviderCommonTypes\BigBoxStatisticsProvider;
              use DataResourceInstructors\OperationComponents\Columns\GroupingByColumn;
              use DataResourceInstructors\OperationComponents\Columns\AggregationColumn;
              use DataResourceInstructors\OperationContainers\OperationGroups\OperationGroup;
              use DataResourceInstructors\OperationTypes\CountOperation;

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
  The output (for status example values 'active' & 'inactive') will be :
  
      [
        "Count of Active Clients" => 4 /* 4 active clients for example */ ,
        "Count of inactive Clients" => 2 /* 2 inactive clients for example */ ,
      ]

Note : We will talk more clearly about using Operation types in its docs part.

#### GroupingByColumn : It is required for instructing OperationContainer to group the data row on a column .
     
    (also you can change it later by '' method ) .
- 
- It is Column typed class ( inherited from Column class) ... So you can use Column class methods .
- It requires you to set the column's alias in 'constructor' or 'create' as a second parameter .
- Example 1 : creating a GroupingByColumn instance :

             GroupingByColumn::create("status" , "statusColumnAlias") /* where status is the column name in database */ 
             or 
             (new GroupingByColumn("status" , "statusColumnAlias")) /* where status is the column name in database */

- Extra methods :
  - setProcessingRequiredForStaticValues(array  $values) : Sets processing required values . 
    - allow you to pass the column's required values to the DataProcessor to instruct it that these values must be in the final result array
      even if it doesn't exist in any database row (in this situation it will fill them by 0 ) .
    - Note for statistics structure using :
      Make sure to use it for the only static values (which they are a few values , and  easy to process by DataProcessor ,
     It can process any set of values but because of the statistics structure used in RunTime request 
     we must take care about the time and resources used in processing ).
    
  - getProcessingRequiredValues() :  Gets the processing required values .
- Example 2 : If we want more customization on the previous example above ,
              We can add setProcessingRequiredForStaticValues method with  client status values (["active" , "inactive"]) , 
              to instruct the DataProcessor which status values must be found in final result array and take care about them in data processing . 
              That means : if no active clients is found in the same filtering and query conditions ... its result value will be 0 ,
                           the same rule will be implemented for inactive clients result value.  
         <?php

                  use Statistics\StatisticsProviders\StatisticsProviderCommonTypes\BigBoxStatisticsProvider;
                  use DataResourceInstructors\OperationComponents\Columns\GroupingByColumn;
                  use DataResourceInstructors\OperationComponents\Columns\AggregationColumn;
                  use DataResourceInstructors\OperationContainers\OperationGroups\OperationGroup;
                  use DataResourceInstructors\OperationTypes\CountOperation;

                   class ClientBigBoxStatisticsProvider extends BigBoxStatisticsProvider
                   {
                       protected function getCountingClientGroupedByStatusOperationGroup() : OperationGroup
                       {
                           $groupingColumn = GroupingByColumn::create("status" , "status")->setProcessingRequiredForStaticValues(["active" , "inactive"]);
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

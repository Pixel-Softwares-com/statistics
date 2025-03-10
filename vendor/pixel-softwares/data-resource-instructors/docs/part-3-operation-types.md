# DataResourceInstructors Structure
## OperationTypes - AggregationOperations

While instructing a DataResource object to implement the designed query maybe you want to some operations to do like sql methods ,
in our structure we prepared some operations to ready use .

### AggregationOperation : is an abstract class contains the common functionality and properties for aggregation operations .

- methods :
  - create() : static method found on the child operation class to create a new instance .
  - getOperationName() : Gets the operation name (ex : sum , count).
  - getAggregationColumns() : Gets the columns will be aggregated (a column will count or the columns will be sum ).
  - setTableName(string $tableName) : Sets the table name to apply the aggregation operation on . 
  - addAggregationColumn(AggregationColumn $column ) : Sets the column will be aggregated .
  - whereAggregatedValue(HavingCondition $condition) : Sets "having" aggregation condition to apply condition on the aggregated value before returning it .
  - getAggregationConditions() : Gets all "having" aggregation conditions set by 'whereAggregatedValue' method .  
  - orderBy(AggregationColumn $column , string $orderingStyleConstant = "") : ordering the results on the by the aggregated columns .
  - getOrderingColumns() : Gets all Columns those set as ordering columns in the operation .
  
- Note ( for database fetchers DataResources ) : All columns added to an operations must be in the same table ,
If you want to join many tables in the query and want to do aggregation operations on separated columns in the tables
you can add an AggregationOperation for each OperationContainer separately   
(where the main table is added into OperationGroup & the other tables added into RelationshipLoader objects ) .

#### Operation Types
Our structure only supports the aggregation operations  , And these are the supported operation types :
- SumOperation
- AverageOperation
- CountOperation : 
  - Because of this operation can't be executed on many columns we added some extra methods to make some specification can help DateResource objects to work with this operation trusted .
  - if no columns added to the operation , a new default column will be returned when 'getAggregationColumns' is called ,
  the default column name = "id" , and its result label = "Count of rows" .
  - methods :
    - getFirstCountedColumn() : Gets the first added AggregationColumn (because only one column will be counted). 
    - getCountedColumnName() : Gets the first added AggregationColumn name .
    - getCountedResultLabel() : Gets the first added AggregationColumn result label .
    - getCountedColumnAlias() : Gets the first added AggregationColumn alias .

#### Defining new AggregationOperation type :
- The statistics package is only supports the AggregationOperation types defined in this structure ,
but you can create new types to use it anywhere else .
- To create a new operation class :
  - create a new class and make it inherited from DataResourceInstructors\OperationTypes\AggregationOperations class .
  - implement the method 'getOperationName' to define the name of operation .
  - now you have an AggregationOperation typed class ,
  you can use its object to instructing a DataResource object to do something using our new operation object.  

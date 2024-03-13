# Statistics Structure

### This structure works with Bridge design pattern , That means each type deals with another type as an abstract type or an interface

<hr>

## Overview on The Main Classes

### - StatisticsBuilderBaseService Class :
It is The builder of StatisticsProvider Decorators , It initializes the StatisticsProvider Objects ,
And wraps them inside each other.

<hr>

### - StatisticsProviderDecorator Class :
- It works with Decorator Design pattern , to give the ability to warp many StatisticsProvider inside each other
  and getting a final array of data contains pairs of keys and values
  (the key is the returned value by getStatisticsTypeName abstract method ).
- It doesn't make any statistics operations or data processing ... It only delegates the operations to DataResources
  and manage them to get the required statistics data from them.
- It Expects An Array Of DataResource classes Which are ordered by Priority of using.
- Its main job to receive the required statistics operations and hold them in OperationTempHolder object
  to pass them later to the convenient DataResource Object .
- It receives the required operation from child StatisticsProviderClass (as default operations) , or from grand child StatisticsProviderClass (if it is needed).
- It will loop on the given DataResource Classes , initializes and uses them , This loop will continue until
  getting non-empty data array from one of these DataResource's initialized objects or until looping on the whole
  DataResource Classes Array (if no data has got from any of these DataResources the empty array will be returned) .
- Ex for DataResources : DBFetcherDataResource Who will do the statistics of the required operations using the Database.
  You can develop another DataResource later to do the statistics of the required operations using the Cache ( for instance ).

### - StatisticsProvider Main Types :
#### BigBoxStatisticsProvider
* Uses DBFetcherDataResource typed DBFetcherGlobalDataResource object for doing statistics by database .
* Doesn't have any default operations  , can be used to add operations and advanced operations and return the result data as associative array of data.

#### ChartStatisticsProvider
*  Uses DBFetcherDataResource typed ChartDBFetcherDataResource for doing statistics by database .
*  Doesn't expect any operations from its child class ... It does the statistics grouped by time period .

#### SmallBoxesStatisticsProvider
* Uses DBFetcherDataResource typed DBFetcherGlobalDataResource object for doing statistics by database .
* It has many default operations :
    - Counting of all rows in the given model's database table .
    - Counting of all rows in the given model's database table <b>those are added into the table in a specific time period <b>.

<hr>

### DataResource Class :
- It is an abstract class to force all child classes to define some methods called by StatisticsProvider classes.
- It expects DataResourceOperationsTempHolder object in constructor , DataProcessor object from child classes .

### DataResource Types :
#### DBFetcherDataResource class
- It will do the statistics of the required operations using the Database.
- It deals with OperationManagement , QueryCustomizationStrategy , DateProcessor , DataProcessor To do the required statistics .

##### DBFetcherDataResource Child Classes :
- DBFetcherGlobalDataResource : It has the normal functionality of DBFetcherDataResource
- ChartDBFetcherDataResource : It defines specific QueryCustomizationStrategy , DateProcessor , DataProcessor
  types to achieve its specific job .
Each of these child classes has a specific way to get statistical data but the style of result is the same.

<hr>

### DateProcessor Class :
- It is an abstract class to force all child classes to define some methods called by DataResource Classes .
- It processes the end date , start date for the current request to use them in the query where condition .

### DateProcessor Types :
#### GlobalDateProcessor : It has the normal functionality of DateProcessor.
#### ChartDateProcessor : Provides extra functionality to generate date period between the start date and end date .

<hr>

### - DataProcessor Class :
- It is an abstract class to force all child classes to define some methods called by DataResource Classes .

### - DataProcessor Types :
#### DBFetchedDataProcessors : They process the data results from query execution in Database , to get a final one level array .

* DBFetchedDataProcessors Child Classes :
    - DBFetchedGlobalDataProcessor : It loops on data and all operation including in the given OperationGroup object
      to replace all aggregation column aliases with the required value found in the data row array .
    - DateGroupedDBFetchedDataProcessor : It uses the DateProcessor to generate a time period and using it in the final data array to get a statistics data array grouped by date .

<hr> 

###  QueryCustomizationStrategy Class :
- It is an abstract class to customize the query using the sql string provided form QueryCustomizationStrategy child classes ,
  and force all child classes to define some methods called by DataResource Classes .

### - QueryCustomizationStrategy Types :
#### CountingQueryCustomizer : Provide The Sql For Counting Column Operation .
#### SumQueryCustomizer : Provide The Sql For getting total value of Column .
#### AverageQueryCustomizer : Provide The Sql For getting average value of Column .
####  Other Types Provided Date Based Sql Customizing Functionality for ChartDBFetcherDataResource .

<hr>

### - OperationManagement Structure :
#### Operations Classes : They are the classes used to instruct DataResource Classes the required operations they must do .
* OperationContainers
  - OperationGroup
  - RelationshipLoader
* OperationTypes
  - AggregationOperation ( AverageOperation , CountOperation , SumOperation)
* QueryComponents
  - Columns ( Column , AggregationColumn ,  GroupingByColumn ) .
  - OperationConditions ( AggregationConditions , JoinConditions  , WhereConditions) .
  - Ordering
  
- OperationsTempHolders Classes : They are temporary boxes to hold the OperationGroups before passing them to DataResource object .

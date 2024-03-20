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

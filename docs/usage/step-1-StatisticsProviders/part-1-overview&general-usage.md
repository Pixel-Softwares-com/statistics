# Statistics Structure - Usage
## StatisticsProviders structure

<hr>

### - StatisticsProviderDecorator Class :
- It is the main class of all StatisticsProvider types . 
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
- Note : the child class (inherited from this class ) is called StatisticsProvider but is stills a StatisticsProviderDecorator type even the name is changed .

### StatisticsProviders

#### Why it is required : 
Generally you need to use  typed class to request it to do some statistical operations ,
There are some common StatisticsProviders types made ready to use for you (They do some operations instead of you) ,
But you maybe need to make a custom one and customize your operations yourself .... The two ways will be explained in this documentation .
<hr>

#### StatisticsProvider Usage Main Way : 
- create a child StatisticsProvider and make it inherited from the parent StatisticsProvider type you need (or custom a new type - advanced - ).
- implement the required methods .
- use public method getStatistics() to get the statistics and return its value in Resource or controller .
- If You Need to use many StatisticsProvider in the same request use StatisticsBuilder (look at its part in docs )  .
- If You need to wrap many operations in the same result key of provider append them in the same provider as OperationGroups ( look at OperationsManagement docs page ) ,
and there is no need to create many StatisticsProviders and processing their value arrays or using StatisticsBuilder.
- Some StatisticsProvider types need extra implementation ... But the implementation concept are the same .

# Statistics Structure - Usage
## StatisticsProviders

<hr>
 
### Why it is required : 
Generally you need to use  typed class to request it to do some statistical operations ,
There are some common StatisticsProviders made ready to use for you ,
But you maybe need to make a custom one .... The two ways will be explained in this documentation .

<hr>

### StatisticsProvider Usage Main Way : 
- create a child StatisticsProvider and make it inherited from the parent StatisticsProvider type you need .
- implement the required methods .
- use public method getStatistics() to get the statistics and return its value in Resource or controller .
- If You Need to use many StatisticsProvider in the same request use StatisticsBuilder (look at its part in docs )  .
- If You need to wrap many operations in the same result key of provider append them in the same provider as OperationGroups ( look at OperationsManagement docs page ) ,
and there is no need to create many StatisticsProviders and processing their value arrays or using StatisticsBuilder.
- Some StatisticsProvider types need extra implementation ... But the implementation concept are the same .

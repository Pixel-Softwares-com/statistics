# Statistics Structure - Usage
## StatisticsProviders

<hr>

###  Generally you need to use StatisticsProvider typed class to request it to do some statistical operations , and there are two types of statisticsProviders in this structure :
- Common Type StatisticsProvider ( Will Be Explained in this docs page) .
- Custom Type StatisticsProvider ( Will be explained in structure development pages) .

<hr>

### StatisticsProvider Usage : 
- create a child StatisticsProvider ad make it inherited from the parent StatisticsProvider you need .
- implement the required methods .
- use public method getStatistics() to get the statistics and return its value in Resource or controller .
- If You Need to use many StatisticsProvider in the same request use StatisticsBuilder (look at its part in docs )  .
- If You need to wrap many operations in the same result key of provider .... append them in the same provider as OperationGroups ( look at OperationsManagement docs page ) and there is no need to create many StatisticsProviders and processing their value arrays or using StatisticsBuilder.
- Some StatisticsProvider types need extra implementation ... But the implementation steps are the same .

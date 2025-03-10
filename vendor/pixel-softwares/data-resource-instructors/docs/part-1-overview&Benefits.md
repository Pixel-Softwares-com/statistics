# DataResourceInstructors Structure

## Concepts 
- client context : inside of service or any class uses statistics package as an example .
- processing context : The main functionality will receive the instructions from client context to process them .

## Overview & Benefits 
- The main benefit of the components in this structure is to be an instruction container for separating the client context from the data processing context 
which allow the processing context to decide how to implement these instructions itself .
- Generally you can use them to instruct DataResources classes which need to know the required query design to execute it properly
(ex : DBFetcherDataResource , CacheDataResource , RemoteServerDataResource , APIDataResource  ... etc ). <br>
In an other word : we can use them in the client context to design the query needed to execute in the processing context to let the processing context have 
a lot of execution options to get data properly .
   
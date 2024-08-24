# Statistics Structure - Usage
## NeededDateProcessorDeterminers - overview & types

### NeededDateProcessorDeterminer abstract class
It is an abstract class to provide an interface to dela with it when there is a need for a DateProcessor .

- public methods :
  - getDateProcessorInstance() : Returns a DateProcessor or null 
  ( this method is implemented by the child DateProcessor Determiner classes ) .

### NeededDateProcessorDeterminer Types :

- GlobalDateProcessorDeterminer :
  It returns the convenient Global DateProcessor after checking period_type request filter.
- DateGroupedDateProcessorDeterminer
  It returns the convenient DateProcessor for statistical chart (chart typed StatisticsProviders) after checking period_type request filter.
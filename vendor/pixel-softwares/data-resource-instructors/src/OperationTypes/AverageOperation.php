<?php

namespace DataResourceInstructors\OperationTypes;

class AverageOperation extends AggregationOperation
{
    static public function getOperationName() : string
    {
        return "avg";
    }

}

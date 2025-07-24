<?php

namespace Statistics\DataResources\DBFetcherDataResources\Traits;

use Statistics\DataResources\DBFetcherDataResources\DBFetcherDataResource;
use Statistics\OperationsManagement\OperationTempHolders\DataResourceOperationsTempHolder;
use Illuminate\Http\Request;

trait Setters
{
    static public function getAcceptedOperationTempHolderClass() : string
    {
        return DataResourceOperationsTempHolder::class;
    }

    public function setRequest( ?Request $request = null) : DBFetcherDataResource
    {
        if(!$request)
        {
            $request = request();
        }
        
        $this->request = $request;
        return $this;
    }

}

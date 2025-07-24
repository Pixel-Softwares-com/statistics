<?php

namespace Statistics\DateProcessors;

use Statistics\DateProcessors\Traits\SingletonInstanceMethods;
use Carbon\Carbon;
use Illuminate\Http\Request;

abstract class DateProcessor
{
    use SingletonInstanceMethods;

    protected ?Request $request;
    protected ?Carbon $startingDate = null;
    protected ?Carbon $endingDate = null;

    protected function __construct()
    {
    }

    protected function getCurrentRequestInstance() : Request
    {
        return request();
    }

    public function setRequest(?Request $request = null) : DateProcessor
    {
        if(!$request)
        {
            $request = $this->getCurrentRequestInstance();
        }

        $this->request = $request;
        return $this;
    }

    protected function getStartingDateRequestKey() : string
    {
        return "from_date";
    }

    protected function getStartingDateRequestValue()  : string
    {
        $requestFilters = $this->request->filter ?? [];
        return $requestFilters[ $this->getStartingDateRequestKey() ] ?? "";
    }

    protected function getEndingDateRequestKey() : string
    {
        return "to_date";
    }

    protected function getEndingDateRequestValue()  : string
    {
        $requestFilters = $this->request->filter ?? [];
        return $requestFilters[ $this->getEndingDateRequestKey() ] ?? "";
    }

    protected function setStartingDate() : DateProcessor
    {
        $this->startingDate = $this->getStartingDateInstance();
        return $this;
    }

    protected function setEndingDate() : DateProcessor
    {
        $this->endingDate = $this->getEndingDateInstance();
        return $this;
    }

    public function getStartingDate() : Carbon
    {
        return $this->startingDate;
    }
    
    public function getEndingDate() : Carbon
    {
        return $this->endingDate;
    }

    abstract public function getStartingDateInstance() : Carbon;
    abstract public function getEndingDateInstance() : Carbon;
}

<?php

namespace Statistics\DateProcessors\NeededDateProcessorDeterminers;

use Statistics\DateProcessors\DateProcessor;
use Illuminate\Http\Request;

abstract class NeededDateProcessorDeterminer
{
    static protected array $instances = [];
    static protected ?Request $request = null;

    static public function Singleton() : NeededDateProcessorDeterminer
    {
        if(array_key_exists(static::class , static::$instances))
        {
            return static::$instances[static::class];
        }
        return new static();
    }

    protected function __construct()
    {
        $this->setRequest();
    }

    /**
     * @return string
     * return the Key by method to allow child class's overriding
     */
    static public function getPeriodTypeRequestKeyName() : string
    {
        return "period_type";
    }
    static protected function setRequest() : void
    {
        if(!static::$request){static::$request = request();}
    }
    static public function getPeriodTypeRequestValue() : string
    {
        $value = static::$request->filter[ static::getPeriodTypeRequestKeyName() ] ?? "";
        return strtolower($value);
    }

    abstract public function getDateProcessorInstance() : DateProcessor | null;
}

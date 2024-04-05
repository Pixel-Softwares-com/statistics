<?php

namespace Statistics\DateProcessors\Traits;

use Statistics\DateProcessors\DateProcessor;
use Illuminate\Http\Request;

trait SingletonInstanceMethods
{
    protected static array $instances = [];
    protected function setInstanceProps(?Request $request = null) : DateProcessor
    {
        return $this->setRequest($request)->setEndingDate()->setStartingDate();
    }
    protected static function createInstance(?Request $request = null): DateProcessor
    {
        return (new static())->setInstanceProps($request);
    }

    final public static function Singleton(?Request $request = null) : DateProcessor
    {
        $className = static::class;

        if (!array_key_exists($className , self::$instances))
        {
            return self::$instances[$className] = static::createInstance($request);
        }
        return self::$instances[$className]->setInstanceProps($request);
    }
}

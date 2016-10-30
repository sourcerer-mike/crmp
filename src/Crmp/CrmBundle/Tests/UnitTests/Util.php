<?php


namespace Crmp\CrmBundle\Tests\UnitTests;


class Util
{
    public static function call($object, $methodName)
    {
        $reflect = new \ReflectionObject($object);
        $method  = $reflect->getMethod($methodName);

        $method->setAccessible(true);

        return call_user_func_array([$method, 'invoke'], func_get_args());
    }
}
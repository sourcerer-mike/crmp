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

    public static function get($object, $field)
    {
        return self::getProperty($object, $field)->getValue($object);
    }

    public static function set($object, $field, $value)
    {
        self::getProperty($object, $field)->setValue($object, $value);
    }

    /**
     * @param $builder
     * @param $string
     *
     * @return \ReflectionProperty
     */
    protected static function getProperty($builder, $string)
    {
        $reflect  = new \ReflectionObject($builder);
        $property = $reflect->getProperty($string);

        $property->setAccessible(true);

        return $property;
    }
}
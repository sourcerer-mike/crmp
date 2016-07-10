<?php

namespace Crmp\CrmBundle;

/**
 * Debug-Helper.
 *
 * @package Crmp\CrmBundle
 */
class Debug
{
    /**
     * Resolve type of a variable,
     *
     * In case of an object, the class name will be returned.
     * For all non-objects `gettpye()` will resolve the type.
     *
     * @param string $something
     *
     * @return mixed
     */
    public static function getType($something)
    {
        if (is_object($something)) {
            return get_class($something);
        }

        return gettype($something);
    }
}

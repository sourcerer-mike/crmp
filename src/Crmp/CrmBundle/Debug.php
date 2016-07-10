<?php

namespace Crmp\CrmBundle;

class Debug
{
    public static function get_type($something)
    {
        if (is_object($something)) {
            return get_class($something);
        }

        return gettype($something);
    }
}

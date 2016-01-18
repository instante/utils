<?php

namespace Instante\Helpers;

use Instante\Utils\StaticClass;

class Strings
{
    use StaticClass;

    public static function afterLast($string, $separator)
    {
        $pos = mb_strrpos($string, $separator);
        return $pos === FALSE ? $string : mb_substr($string, $pos + mb_strlen($separator));
    }
}

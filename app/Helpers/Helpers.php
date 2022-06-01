<?php

namespace App\Helpers;

use PhpParser\Node\Expr\Array_;

class Helpers
{
    /**
     * Remove all indices of an array except those specified as keepers
     * @param array $arr
     * @param array $keep
     * @return Array
     */
    static function trim(Array $arr,Array $keepers): Array
    {
        foreach ($arr as $var => $value) {
            if (array_search($var,$keepers) === false) {
                unset ($arr[$var]);
            }
        }
        return $arr;
    }
}

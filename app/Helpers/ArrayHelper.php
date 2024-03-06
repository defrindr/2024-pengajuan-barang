<?php

namespace App\Helpers;

class ArrayHelper
{
    public static function replaceKey(array $parent, array $matched): array
    {

        foreach ($matched as $removedKey => $newKey) {
            if (array_key_exists($removedKey, $parent)) {
                $parent[$newKey] = $parent[$removedKey];
                unset($parent[$removedKey]);
            }
        }

        return $parent;
    }
}

<?php

function searchValInAssocArr($arrays, $needleNumber): ?int
{
    foreach ($arrays as $key => $array) {
        if (in_array($needleNumber, $array)) {
            return $key;
        }
    }
    return null;
}

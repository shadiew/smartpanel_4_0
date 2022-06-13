<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 

/**
 * V3.6
 * Convert Strings (ID lists ) to array
 * Using for search multi order ID on Order page
 * @param input $string
 */
if (!function_exists('convert_string_number_list_to_array')) {
    function convert_str_number_list_to_array($str)
    {
        $ar = [];
        if (!is_string($str)) {
            return $ar;
        }
        $str = rtrim($str, ',');
        $str = ltrim($str, ',');
        return $ar = explode(',', $str);
    }
}


/**
 * V3.6
 * Group items from an array together by some criteria or value.
 * @param  $arr array The array to group items from
 * @param  $criteria string|callable The key to group by or a function the returns a key to group by.
 * @return array
 *
 */
if (!function_exists('group_by_criteria')) {
    function group_by_criteria($arr, $criteria)
    {
        return array_reduce($arr, function($accumulator, $item) use ($criteria) {
            $key = (is_callable($criteria)) ? $criteria($item) : $item[$criteria];
            if (!array_key_exists($key, $accumulator)) {
                $accumulator[$key] = [];
            }
            array_push($accumulator[$key], $item);
            return $accumulator;
        }, []);
    }
}

/**
 * From V3.6
 * Sort Services by ID
 * @param array $arr
 * @param $new_key string|callable  The new key to re-sort array
 * @return array
 */
if (!function_exists('array_sort_by_new_key')) {
    function array_sort_by_new_key($array = [], $new_key)
    {
        $result = [];
        if (is_array($array) && $array) {
            $array_new_keys   = array_column($array, $new_key);
            $result           = array_combine(array_values($array_new_keys), array_values($array));
        }
        return $result;
    }
}


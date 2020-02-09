<?php
namespace App\App\Core;

class Filters
{
    // FILTER OPERATOR
    const EQUALS_THAN = "==";
    const NOT_EQUALS_THAN = "!=";
    const GREATER_THAN = ">";
    const LOWER_THAN = "<";
    const GREATER_THAN_EQUALS = ">=";
    const LOWER_THAN_EQUALS = "<=";

    /**
     * @param $list
     * @param array $filters = [
     *  "field_key" => [
     *      "value" => "filter value"
     *      "operator" => "FILTER OPERATOR"
     *  ]
     * ]
     */
    public static function list(&$list, $filters=[]){
        foreach ($filters as $filterKey => $value) {
            $list = array_values(array_filter($list, function ($item) use ($filterKey, $value) {
                if ($value["operator"] == self::NOT_EQUALS_THAN) {
                    $list = ($item[$filterKey] != $value["value"]);
                } elseif ($value["operator"] == self::GREATER_THAN) {
                    $list = ($item[$filterKey] > $value["value"]);
                } elseif ($value["operator"] == self::LOWER_THAN) {
                    $list = ($item[$filterKey] < $value["value"]);
                } elseif ($value["operator"] == self::GREATER_THAN_EQUALS) {
                    $list = ($item[$filterKey] >= $value["value"]);
                } elseif ($value["operator"] == self::LOWER_THAN_EQUALS) {
                    $list = ($item[$filterKey] <= $value["value"]);
                } else {
                    $list = ($item[$filterKey] == $value["value"]);
                }
                return $list;
            }));
        }
    }

}
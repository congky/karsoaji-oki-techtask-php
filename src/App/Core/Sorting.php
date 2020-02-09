<?php
namespace App\App\Core;

class Sorting
{
    /**
     * @param $list
     * @param $orders = [
     *  "field_key" => "sort type, support : SORT_ASC, SORT_DESC"
     * ]
     */
    public static function list(&$list, $orders) {
        usort($list, function ($a, $b) use($orders) {
            $arr1 = [];
            $arr2 = [];
            foreach ($orders as $key => $type) {
                if($type == SORT_ASC) {
                    $arr1[] = $a->$key;
                    $arr2[] = $b->$key;
                } else {
                    $arr1[] = $b->$key;
                    $arr2[] = $a->$key;
                }
            }
            return $arr1 <=> $arr2;
        });
    }
}
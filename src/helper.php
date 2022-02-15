<?php

if (!function_exists('make_tree')) {
    function make_tree(array $array)
    {
        $items = array();

        foreach ($array as $value) {
            $items[$value['id']] = $value;
        }

        $tree = array();
        foreach ($items as $key => $value) {
            if (isset($items[$value['p_id']])) {
                $items[$value['p_id']]['children'][] = &$items[$key];
            } else {
                $tree[] = &$items[$key];
            }
        }

        return $tree;
    }
}
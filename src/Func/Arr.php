<?php

namespace DTL\Func;

class Arr
{
    /**
     * 獲取陣列內容，並支援點式語法
     *
     * @param      $array
     * @param      $key
     * @param null $default
     * @return mixed|null
     */
    public static function get($array, $key, $default = null)
    {
        if(!is_array($array) || !$key){
            return $default;
        }

        if (array_key_exists($key, $array)) {
            return $array[$key];
        }

        foreach (explode('.', $key) as $segment) {
            if (is_array($array) && array_key_exists($segment, $array)) {
                $array = $array[$segment];
            } else {
                return $default;
            }
        }

        return $array;
    }

    /**
     * 將一維陣列按照指定的字段分組
     *
     * @param array $array
     * @param       $fieldName
     * @param bool  $is_multi
     * @return array|bool
     */
    public static function group_by(Array $array, $fieldName, $is_multi = false)
    {
        if (is_array($array) && $fieldName) {
            $tmp = [];
            foreach ($array as $v) {
                if (isset($v[$fieldName]) && $v[$fieldName]) {
                    if ($is_multi) {
                        $tmp[$v[$fieldName]][] = $v;
                    } else {
                        $tmp[$v[$fieldName]] = $v;
                    }
                }
            }

            return $tmp;
        }

        return false;
    }

    /**
     * 將數據根據某個字段排序 支持desc和asc
     * 1.目前只能支持全部desc或者asc，如需使用根據字段隨意的asc,desc 請使用column_multisort
     * @param  array  需要排序的數據
     * @param  mixed  排序字段列表 eg. name,age
     * @param  string 排序規則 asc,desc default: desc
     * @return array
     */
    public static function column_sort(Array & $data, $columns, $order = 'desc')
    {
        $order = strtolower($order);
        if (is_string($columns)) {
            $columns = explode(',', $columns);
        }
        if (empty($columns)) {
            return false;
        }
        $array_column_sort_tmp_func = function ($columnss, $order) {
            return function ($a, $b) use ($columnss, $order) {
                foreach ($columnss as $columns) {
                    if ($a[$columns] == $b[$columns]) {
                        continue;
                    }
                    if ($order == 'desc') {
                        return $a[$columns] < $b[$columns];
                    } else {
                        if ($order == 'asc') {
                            return $a[$columns] > $b[$columns];
                        }
                    }
                    return false;
                }
            };
        };

        usort($data, $array_column_sort_tmp_func($columns, $order));
    }

    /**
     * 將陣列按照指定字段升降序排列
     * 模擬sql中的寫法
     * @param  array  $list 需要排序的二維陣列
     * @param  string $sort_map 排序方式 與sql中的order寫法一致 asc升序 desc降序
     * 比如name asc,age desc 多個字段以逗號分隔，排序值以空格分隔
     * 也可以寫作name,age desc 默認是asc
     */
    public static function column_multisort(Array & $list, $sort_map)
    {
        $field_sort     = explode(',', trim(trim($sort_map, ',')));
        $final_sort_arr = [];
        foreach ($field_sort as $k => $value) {
            list($field, $sort_type) = explode(' ', $value);
            if (empty($field)) {
                return false;
            }

            switch ($sort_type) {
                case 'asc':
                    $sort_type = SORT_ASC;
                    break;
                case 'desc':
                    $sort_type = SORT_DESC;
                    break;
                default:
                    $sort_type = SORT_ASC;
                    break;
            }

            $field_data = array_column($list, $field);
            if (empty($field_data)) {
                return false;
            }

            $final_sort_arr = array_merge($final_sort_arr, [
                $field_data,
                $sort_type,
            ]);
        }
        $final_sort_arr[] = &$list;

        call_user_func_array('array_multisort', $final_sort_arr);
    }
}

<?php

namespace DTL\FT;

class Number
{
    /**
     * 保留指定位數小數
     *
     * @param     $num
     * @param int $size
     * @return float|int
     */
    public static function float_floor($num, $size = 2)
    {
        $str = strval($num);
        list($int, $float) = explode('.', $str);
        $float = substr($float, 0, $size);

        return $float > 0 ? floatval($int . '.' . $float) : intval($int);
    }

    /**
     * 過濾字符串內的字符串
     *
     * @param      $str
     * @param bool $float 是否保留小數
     * @return string
     */
    public static function filter_num($str, $float = false)
    {
        $preg = $float ? '[0-9\.]*' : '\d*';
        $num  = preg_match_all("/{$preg}/", $str, $out);

        return ($num) ? join(array_values($out[0])) : '';
    }
}

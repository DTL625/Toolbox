<?php

namespace DTL\FT;

class string
{
    /**
     * 截取字符串並添加省略符
     * @param        $str
     * @param int    $len
     * @param string $subFix
     * @return string
     */
    function cut_str($str, $len = 5, $subFix = '...')
    {
        return mb_substr($str, 0, $len) . (mb_strlen($str) > $len ? $subFix : '');
    }
}

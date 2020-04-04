<?php

namespace DTL\Func;

class Debug
{
    /**
     * 打印傳入的所有參數，並結束程序
     */
    public static function buildStr($value)
    {
        $type      = gettype($value);
        $print_str = '';
        switch ($type) {
            case 'integer':
                $print_str .= "({$type}) {$value}";
                break;
            case 'double':
                $print_str .= "({$type}) {$value}";
                break;
            case 'string':
                $value     = $value ? : "''";
                $print_str .= "({$type}) {$value}";
                break;
            case 'boolean':
                $print_str .= "(boolean) " . ($value ? 'true' : 'false');
                break;
            case 'NULL':
                $print_str .= 'NULL';
                break;
            case 'array':
            case 'object':
                $print_str .= print_r($value, true);
                break;

            default:
                $print_str .= '參數type異常';
                break;
        }

        return $print_str;
    }

    public static function output($content)
    {
        if (PHP_SAPI == 'cli') {
            echo $content;
        } else {
            ob_end_clean();
            echo "<meta charset='UTF-8'><pre class='xdebug-var-dump' dir='ltr'>", PHP_EOL;
            echo $content;
            echo '</pre>';
        }
    }

    public static function pe()
    {
        $out = '';
        foreach (func_get_args() as $v) {
            $out .= print_r(self::buildStr($v), true) . PHP_EOL;
        }
        self::output($out);
        die;
    }

    public static function p()
    {
        $out = '';
        foreach (func_get_args() as $v) {
            $out .= print_r(self::buildStr($v), true) . PHP_EOL;
        }
        self::output($out);
    }

    /**
     * 實時輸出文本內容
     *
     * @param string $msg
     */
    public static function show_trace_info($msg = '')
    {
        ob_start();
        echo date('m-d H:i:s'), ',memory:' . self::memory_usage_convert(memory_get_usage(true)), ' ';
        if (is_string($msg)) {
            echo $msg;
        } else {
            print_r($msg);
        }
        echo PHP_SAPI == 'cli' ? PHP_EOL : '<br/>';
        ob_end_flush();
        flush();
    }

    /**
     * 將字節大小轉換為可讀性強的帶單位的顯示方式
     *
     * @param $size
     * @return string
     */
    public static function memory_usage_convert($size)
    {
        $unit = ['b', 'kb', 'mb', 'gb', 'tb', 'pb'];

        return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . '' . $unit[$i];
    }
}

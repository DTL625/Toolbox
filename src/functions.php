<?php
/**
 * 打印並結束程序
 */
if (!function_exists('pe')) {
    function pe()
    {
        call_user_func_array('\DTL\FT\Debug::pe', func_get_args());
    }
}

/**
 * 打印
 */
if (!function_exists('p')) {
    function p()
    {
        call_user_func_array('\DTL\FT\Debug::p', func_get_args());
    }
}

/**
 * 實時輸出字串
 */
if (!function_exists('show_trace_info')) {
    function show_trace_info($msg)
    {
        call_user_func('\DTL\FT\Debug::show_trace_info', $msg);
    }
}

if (!function_exists('dtl_is')) {
    function dtl_is($value, $rule)
    {
        if (is_callable('\DTL\FT\Validate::is_' . $rule)) {
            return call_user_func('\DTL\FT\Validate::is_' . $rule, $value);
        } else {
            throw new Exception("{$rule} does not support.");
        }
    }
}

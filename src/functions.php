<?php
/**
 * 輸出內容並結束程序
 */
if (!function_exists('pe')) {
    function pe()
    {
        call_user_func_array('\DTL\Func\Debug::pe', func_get_args());
    }
}

/**
 * 輸出內容
 */
if (!function_exists('p')) {
    function p()
    {
        call_user_func_array('\DTL\Func\Debug::p', func_get_args());
    }
}

/**
 * 實時輸出字符串
 */
if (!function_exists('show_trace_info')) {
    function show_trace_info($msg)
    {
        call_user_func('\DTL\Func\Debug::show_trace_info', $msg);
    }
}

if (!function_exists('dtl_is')) {
    function dtl_is($value, $rule)
    {
        if (is_callable('\DTL\Func\Validate::is_' . $rule)) {
            return call_user_func('\DTL\Func\Validate::is_' . $rule, $value);
        } else {
            throw new Exception("{$rule} does not support.");
        }
    }
}

<?php

namespace DTL\FT;

class Validate
{
    /**
     * 是否中國手機號
     *
     * @param $value
     */
    public static function is_mobile($value)
    {
        return self::regex($value, '/^1(3[0-9]|4[57]|5[0-35-9]|7[0135678]|8[0-9])\\d{8}$/');
    }

    /**
     * 是否日期
     *
     * @param $value
     * @return bool
     */
    public static function is_date($value)
    {
        return false !== strtotime($value);
    }

    /**
     * 是否純字母
     *
     * @param $value
     * @return bool
     */
    public static function is_alpha($value)
    {
        return self::regex($value, '/^[A-Za-z]+$/');
    }

    /**
     * 是否數字字母
     *
     * @param $value
     * @return bool
     */
    public static function is_alphaNum($value)
    {
        return self::regex($value, '/^[A-Za-z0-9]+$/');
    }

    /**
     * 是否純漢字
     *
     * @param $value
     * @return bool
     */
    public static function is_chs($value)
    {
        return self::regex($value, '/^[\x{4e00}-\x{9fa5}]+$/u');
    }

    /**
     * 是否字母漢字
     *
     * @param $value
     * @return bool
     */
    public static function is_chsAlpha($value)
    {
        return self::regex($value, '/^[\x{4e00}-\x{9fa5}a-zA-Z]+$/u');
    }

    /**
     * 是否數字字母漢字
     *
     * @param $value
     * @return bool
     */
    public static function is_chsAlphaNum($value)
    {
        return self::regex($value, '/^[\x{4e00}-\x{9fa5}a-zA-Z0-9]+$/u');
    }

    /**
     * 是否漢字、字母、數字和下滑線_及破折號-
     *
     * @param $value
     * @return bool
     */
    public static function is_chsDash($value)
    {
        return self::regex($value, '/^[\x{4e00}-\x{9fa5}a-zA-Z0-9\_\-]+$/u');
    }

    /**
     * 是否郵箱
     *
     * @param $value
     * @return bool
     */
    public static function is_email($value)
    {
        return self::filter($value, FILTER_VALIDATE_EMAIL);
    }

    /**
     * 是否url
     *
     * @param $value
     * @return bool
     */
    public static function is_url($value)
    {
        return self::filter($value, FILTER_VALIDATE_URL);
    }

    /**
     * 是否ip
     *
     * @param $value
     * @return bool
     */
    public static function is_ip($value)
    {
        return self::filter($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6);
    }

    /**
     * 使用正規表達式驗證數據
     *
     * @access protected
     * @param mixed $value 字段值
     * @param mixed $rule 驗證規則 正則規則或者預定義正則名
     * @return mixed
     */
    protected static function regex($value, $rule)
    {
        if (0 !== strpos($rule, '/') && !preg_match('/\/[imsU]{0,4}$/', $rule)) {
            // 不是正規表達式則兩端補上/
            $rule = '/^' . $rule . '$/';
        }
        return 1 === preg_match($rule, (string) $value);
    }

    /**
     * 使用filter_var方式驗證
     *
     * @access protected
     * @param mixed $value 字段值
     * @param mixed $rule 驗證規則
     * @return bool
     */
    protected static function filter($value, $rule)
    {
        if (is_string($rule) && strpos($rule, ',')) {
            list($rule, $param) = explode(',', $rule);
        } else if (is_array($rule)) {
            $param = isset($rule[1]) ? $rule[1] : null;
        } else {
            $param = null;
        }
        return false !== filter_var($value, is_int($rule) ? $rule : filter_id($rule), $param);
    }

}

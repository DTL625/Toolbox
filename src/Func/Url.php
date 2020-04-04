<?php

namespace DTL\Func;

class Url
{
    /**
     * 追加url參數到url中,如果已存在，則覆蓋。
     *
     * @param       $url
     * @param array $appendQueryParams
     * @return string
     */
    public static function append_query_params($url, $append_query_params = [])
    {
        if (!Validate::is_url($url)) {
            return '';
        }

        $urlParse = parse_url($url);
        $query    = [];
        if (isset($urlParse['query'])) {
            parse_str($urlParse['query'], $query);
        }
        $query = array_merge($query, $append_query_params);

        return join('', [
            isset($urlParse['scheme']) ? $urlParse['scheme'] . '://' : '',
            $urlParse['host'],
            isset($urlParse['path']) ? $urlParse['path'] : '',
            $query ? '?' : '',
            http_build_query($query),
        ]);
    }
}

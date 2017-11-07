<?php

if (!function_exists('format_ym')) {
    function format_ym($ym, $only_month = false)
    {
        $year = substr($ym, 0, 4);
        $month = substr($ym, 4, 2);
        if ($only_month) {
            $str = intval($month) . '月';
        } else {
            $str = $year . '年' . intval($month) . '月';
        }
        return $str;
    }
}

if (!function_exists('format_date')) {
    function format_date($date, $format)
    {
        $str = '';
        if (isset($date)) {
            $str = \Carbon\Carbon::parse($date)->format($format);
        }
        return $str;
    }
}


if (!function_exists('format_price')) {
    function format_price($price)
    {
        $format_price = 0;
        if (isset($price)) {
            $format_price = number_format($price, 2);
        }
        return $format_price;
    }
}


if (!function_exists('format_data')) {
    function format_data($data)
    {
        $result = [];
        $result['code'] = 200;
        $result['msg'] = 'success';
        $result['data'] = $data;

        return $result;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: qzhang
 * Date: 2016/6/14
 * Time: 16:13
 */

namespace Xiaoshu\Foundation\Util;


class Filter
{
    public static function sliceStr($data, $number = 10)
    {
        $shortStr = mb_substr($data, 0, $number);

        if ($number < mb_strlen($data)){
            $shortStr .= '...';
        }

        return $shortStr;
    }

    public static function sliceArr2Str($data, $number = 1)
    {
        $shortArr = array_slice($data, 0, $number);

        $str = implode(' , ', $shortArr);

        if ($number < count($data)){
            $str .= '...';
        }

        return $str;
    }
}

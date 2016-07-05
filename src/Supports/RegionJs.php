<?php
/**
 * Created by PhpStorm.
 * User: qzhang
 * Date: 2016/5/19
 * Time: 13:27
 */

namespace Xiaoshu\Foundation\Supports;


class RegionJs
{
    public static function getJs()
    {
        $cities = City::getCitysGroupbyProvince();
        $regions = City::getRegionsGroupbyCity();
        $jsText = "var _province_city_map=" . self::array2json($cities) . ";
                   var _city_region_map=" . self::array2json($regions) . ";";
        return $jsText;
    }
    /**
     * 数组转为json
     * 先urlencode，再urldecode，解决中文乱码的问题
     * @param mixed $arr
     * @param bool $object
     * @return string
     */
    public static function array2json($arr, $object = true)
    {
        if (empty($arr)) {
            return $object ? "{}" : "[]";
        }

        $arr = self::encodeArr($arr, true);
        $json = json_encode($arr);
        return self::encodeArr($json, false);
    }

    /**
     * urlencode/urldecode 字符
     * @param mixed $data
     * @param bool $encode
     * @return mixed
     */
    private static function encodeArr($data, $encode = true)
    {
        $replace = array(
            "\r" => "\\r",
            "\n" => "\\n",
            "\t" => " ",
            "\\" => "\\\\",
            '"' => '\"'
        );

        if (is_string($data)) {
            return $encode ? urlencode(strtr($data, $replace)) : urldecode($data);
        } else if (is_array($data)) {
            $newData = array();
            foreach ($data as $key => $val) {
                $key = $encode ? urlencode(strtr($key, $replace)) : urldecode($key);
                $newData[$key] = self::encodeArr($val, $encode);
            }

            return $newData;
        } else {
            return $data;
        }
    }
}

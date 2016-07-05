<?php
/**
 * Date: 16/5/12
 * Time: 上午11:08
 */

namespace Xiaoshu\Foundation\Util;


class Option
{
    /**
     * 将default数组key对应的value , 替换成option中key对应的value
     *
     * @param array $default
     * @param array $option
     * @return array
     */
    public static function join(array $default , array $option = [])
    {
        $result  = [];
        foreach($default as $key => $value) {
            $result[$key]  = isset($option[$key]) ? $option[$key] : $value ;
        }

        return $result;
    }

    /**
     * 用$keys从option中筛选出匹配的值
     *
     * @param array $keys
     * @param array $option
     * @return array
     */
    public static function filter(array $keys , array $option = [])
    {

        return array_reduce($keys ,function($result , $key) use ($option){
            if(array_key_exists($key , $option)){
                $result[$key] = $option[$key];
            }
            return $result;
        }, []);
    }

    /**
     * 用$keys 从$defaults 中筛选需要的值
     * @param array $defaults
     * @param array $keys
     * @return mixed
     */
    public static function inKeys(array $defaults ,array $keys )
    {
        return array_reduce($keys,function($result,$key) use ($defaults){
            if(array_key_exists($key , $defaults)){
                $result[] = $defaults[$key];
            }
            return $result;
        },[]);
    }

    public static function withoutBlank(array $data)
    {
        $result = [];
        foreach($data as $key => $value){
            if(is_null($value) || $value === ''){
                continue;
            }
            $result[$key] = $value;
        }
        return $result;
    }

}

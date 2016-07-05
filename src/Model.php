<?php
/**
 * Date: 16/5/9
 * Time: 上午11:12
 */

namespace Xiaoshu\Foundation;

use Xiaoshu\Foundation\Util\Option;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * 众包项目的公共Model
 *
 * Class Model
 * @package App\Core
 * @author zhuming
 */
class Model extends Eloquent
{

    /*---------------------------------------
     * const
     --------------------------------------*/
    const ARRAY_TO_STRING_DELIMITER = '|';

    /*---------------------------------------
     * properties
     --------------------------------------*/

    protected $arrayFilter = [];

    /*---------------------------------------
     * boot
     --------------------------------------*/


    /*---------------------------------------
     * static methods
     --------------------------------------*/

    /**
     * Model中把数组转化为字符串存入字段的通用方法
     * @param array $array
     * @return string
     */
    public static function arrayToField(array $array)
    {
        if(empty($array)){
            return '';
        }

        $delimiter = self::ARRAY_TO_STRING_DELIMITER;

        $str = implode($delimiter,$array);
        return $delimiter.$str.$delimiter;
    }

    /**
     * Model中把字段中的字符串转化为数组的通用方法
     * @param string $field
     * @return array
     */
    public static function fieldToArray($field)
    {
        if(empty($field)){
            return [];
        }

        $delimiter = self::ARRAY_TO_STRING_DELIMITER;
        $field     = trim($field , $delimiter);
        return explode($delimiter,$field);
    }

    /**
     * Model中把键值对序列化的通用做法
     * @param array $dict
     * @param array $default
     * @return string
     */
    public static function dictToField(array $dict , array $default = [])
    {
        if($default){
            $dict = Option::join($default,$dict);
        }

        return json_encode($dict);
    }

    /**
     * Model中把字段值序列化的通用做法
     * @param string $field
     * @param array $default
     * @return array
     */
    public static function fieldToDict($field , array $default = [])
    {
        $dict  = json_decode($field);
        if($default){
            $dict = Option::join($default,$field);
        }
        return $dict;
    }


    /*---------------------------------------
     * public methods
     --------------------------------------*/

    /**
     * @param string|array $keys
     * @return array
     */
    public function toArrayOfKeys($keys)
    {

        $useFilter  = !is_array($keys) && array_key_exists($keys,$this->arrayFilter);

        if($useFilter){
            $filterKeys  = $this->arrayFilter[$keys];
        } else {
            $filterKeys  = $keys;
        }

        $resource   =   $this->toArray();

        $result     =   Option::filter($filterKeys , $resource);

        return $result;
    }

    /**
     * @param string|array $keys
     * @param int $option
     * @return string
     */
    public function toJsonOfKeys($keys, $option = 0)
    {
        $array = $this->toArrayOfKeys($keys);
        return json_encode($array,$option);
    }

    /*---------------------------------------
     * scope
     --------------------------------------*/

    public function scopeLike($query,$field = null , $value = null)
    {
        if($field && $value){
            $query = $query->where($field,'like',"%$value%");
        }

        return $query;
    }

    public function scopeArrayFieldLike($query , $field = null ,$value = null)
    {
        if($field && $value){
            $delimiter = self::ARRAY_TO_STRING_DELIMITER;
            $value     = $delimiter.$value.$delimiter;
            $query     = $query->where($field,'like',"%$value%");
        }

        return $query;
    }

    public function scopeFieldBetween($query ,$field , $start = null , $end = null)
    {
        if($start){
            $query = $query->where($field,'>=',$start);
        }

        if($end){
            $query = $query->where($field,'<',$end);
        }

        return $query;
    }

    /**
     * @param Builder $query
     * @param string $field
     * @param null|string $startDay
     * @param null|string $endDay
     * @return mixed
     */
    public function scopeDayBetween($query , $field , $startDay = null , $endDay = null)
    {
        if($startDay){
            $start = $startDay.' 00:00:00' ;
            $query = $query->where($field,'>=',$start);
        }

        if($endDay){
            $end   = $endDay.' 23:59:59';
            $query = $query->where($field,'<=',$end);
        }

        return $query;
    }

    /*---------------------------------------
     * relation
     --------------------------------------*/


    /*---------------------------------------
     * extends
     --------------------------------------*/

    public function make($abstract , $parameters = [])
    {
        return app($abstract,$parameters);
    }

    /*---------------------------------------
     * mutator
     --------------------------------------*/


}

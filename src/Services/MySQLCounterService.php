<?php
/**
 * Created by PhpStorm.
 * User: qzhang
 * Date: 2016/7/12
 * Time: 11:29
 */

namespace Xiaoshu\Foundation\Services;

use DB;
use Xiaoshu\Foundation\Exceptions\MySQLCounterExistException;

class MySQLCounterService
{
    const TABLE_NAME = 'xiaoshu_foundation_mysql_counter';
    public static function create($name)
    {
        $count = DB::table(self::TABLE_NAME)->where('name', $name)->count();
        if ($count) {
            throw new MySQLCounterExistException();
        } else {
            DB::table(self::TABLE_NAME)->insert([
                'name' => $name,
                'number' => 0,
            ]);
        }

    }

    public static function inc($name)
    {
        $tableName = self::TABLE_NAME;
        DB::select("update $tableName set number=last_insert_id(number+1) where name='$name';");
        $res = DB::select('select last_insert_id() as id');
        return $res[0]->id;
    }

    public static function delete($name)
    {
        DB::table(self::TABLE_NAME)->where('name', $name)->delete();
    }

    public static function getValue($name)
    {
        return DB::table(self::TABLE_NAME)->where('name', $name)->value('number');
    }
}
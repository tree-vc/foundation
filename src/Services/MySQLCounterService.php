<?php
/**
 * Created by PhpStorm.
 * User: aibang
 * Date: 2016/7/12
 * Time: 11:29
 */

namespace Xiaoshu\Foundation\Services;

use DB;

class MySQLCounterService
{
    const TABLE_NAME = 'xiaoshu_foundation_mysql_counter';
    public static function create($name)
    {
        $count = DB::table(self::TABLE_NAME)->where('name', $name)->count();
        if ($count) {
            return false;
        } else {
            DB::table(self::TABLE_NAME)->insert([
                'name' => $name,
                'number' => 0,
            ]);
            return true;
        }

    }

    public static function inc($name)
    {
        $tableName = self::TABLE_NAME;
        DB::select("update $tableName set number=last_insert_id(number+1) where name='$name';");
        $res = DB::select('select last_insert_id() as id');
        return $res[0]->id;
    }
}
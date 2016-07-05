<?php
/**
 * Date: 16/5/12
 * Time: 上午10:21
 */

namespace Xiaoshu\Foundation;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\Log;
use Exception;

/**
 * 业务逻辑的基类
 * 业务逻辑中使用try catch
 * 涉及多表的业务逻辑, 管理数据库业务
 *
 * Class Logic
 * @package App\Core
 *
 * @author zhuming
 */
class Logic
{
    protected $app;

    public function __construct(Container $app)
    {
        $this->app = $app;
    }

    protected function make($abstract , $parameters = [])
    {
        return $this->app->make($abstract , $parameters);
    }

    protected function inject($abstract , $parameters = [])
    {
        return $this->app->make($abstract , $parameters);
    }


    protected function beginTransaction()
    {
        DB::beginTransaction();
    }

    protected function rollback()
    {
        DB::rollBack();
    }

    protected function commit()
    {
        DB::commit();
    }

    protected function logError($method ,Exception $e)
    {
        Log::error($method.' fail:'.$e->getMessage().' in '.$e->getFile().' at '.$e->getLine() , []);
    }

}

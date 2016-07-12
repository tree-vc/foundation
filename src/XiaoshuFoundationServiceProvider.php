<?php
/**
 * Created by PhpStorm.
 * User: aibang
 * Date: 2016/7/12
 * Time: 10:24
 */

namespace Xiaoshu\Foundation;


use Illuminate\Support\ServiceProvider;

class XiaoshuFoundationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //migrations
        $this->publishes([
            __DIR__.'/migrations' => database_path('migrations'),
        ]);

    }

    public function register()
    {

    }
}
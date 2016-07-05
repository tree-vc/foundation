<?php

/**
 * Created by PhpStorm.
 * User: qzhang
 * Date: 2016/6/28
 * Time: 11:32
 */

use Xiaoshu\Foundation\Util\Option;

class OptionTest extends TestCase
{
    public function testJoin()
    {
        $expect = ['name'=>'tom', 'age'=>10];
        $default = ['name'=>'tom', 'age'=>1];
        $option = ['age'=>10];
        $this->assertEquals($expect, Option::join($default, $option));
    }

    public function testFilter()
    {
        $expect = ['name'=>'tom', 'age'=>10];
        $keys = ['name', 'age'];
        $option = ['name'=>'tom', 'age'=>10, 'money'=>10000];
        $this->assertEquals($expect, Option::filter($keys, $option));
    }

    public function testInKeys()
    {
        $expect = ['tom', 10];
        $defaults = ['name'=>'tom', 'age'=>10, 'money'=>10000];
        $keys = ['name', 'age'];
        $this->assertEquals($expect, Option::inKeys($defaults, $keys));
    }

    public function testWithoutBlank()
    {
        $expect = ['name'=>'tom', 'age'=>10, 'money'=>10000];
        $data = ['name'=>'tom', 'age'=>10, 'money'=>10000, 'like'=>''];
        $this->assertEquals($expect, Option::withoutBlank($data));
    }
}
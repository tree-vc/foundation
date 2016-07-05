<?php
/**
 * Created by PhpStorm.
 * User: qzhang
 * Date: 2016/6/28
 * Time: 13:59
 */

use Xiaoshu\Foundation\Util\Filter;

class FilterTest extends TestCase
{
    public function testSliceStr()
    {
        $expect = '1234567891...';
        $data = '123456789123';
        $this->assertEquals($expect, Filter::sliceStr($data));
    }
    public function testSliceStrP()
    {
        $expect = '123...';
        $data = '123456789123';
        $this->assertEquals($expect, Filter::sliceStr($data, 3));
    }

    public function testSliceArr2Str()
    {
        $expect = 'bing...';
        $data = ['bing', 'google', 'sogou'];
        $this->assertEquals($expect, Filter::sliceArr2Str($data));
    }
    public function testSliceArr2StrP()
    {
        $expect = 'bing , google...';
        $data = ['bing', 'google', 'sogou'];
        $this->assertEquals($expect, Filter::sliceArr2Str($data, 2));
    }
}
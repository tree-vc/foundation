<?php
/**
 * Date: 16/5/11
 * Time: 下午3:53
 */

use Xiaoshu\Foundation\Result\Result;


class ResultTest extends TestCase
{

    public function testArrayable()
    {
        $expect = ['status' => true , 'msg' => 'test case', 'time' => date('Y-m-d H:i:s')];
        $result = new Result(true , $expect['msg']);
        $this->assertEquals($expect , $result->toArray());
    }

    public function testJson()
    {
        $expect = ['status' => true , 'msg' => 'test case', 'time' => date('Y-m-d H:i:s')];
        $result = new Result(true , $expect['msg']);
        $this->assertEquals(
            json_encode($expect),
            $result->toJson()
        );
    }

    public function testMake()
    {
        $test1  = new Result(true , 'hello');
        $test2  = Result::success('hello');
        $test3  = Result::make(['status' => true, 'msg' => 'hello']);
        $expect = ['status'=>true , 'msg'=>'hello', 'time' => date('Y-m-d H:i:s')];

        $this->assertEquals($expect,$test1->toArray());
        $this->assertEquals($expect,$test2->toArray());
        $this->assertEquals($expect,$test3->toArray());

    }

    public function testSet()
    {
        $result = Result::success('hello')->set('a' , 1)->set('b', 2);
        $expect = [
            'status'    => true,
            'msg'       => 'hello',
            'a'         => 1,
            'b'         => 2,
            'time'      => date('Y-m-d H:i:s'),
        ];

        $this->assertEquals($expect,$result->toArray());
    }

    public function testWith()
    {
        $expect = [
            'status'    => true,
            'msg'       => 'hello',
            'a'         => 1,
            'b'         => 2,
            'time'      => date('Y-m-d H:i:s'),
        ];
        $result = Result::success('hello')->with($expect);
        $this->assertEquals($expect,$result->toArray());
    }

    public function testIsSuccess()
    {
        $result = Result::fail('hello');
        $this->assertFalse($result->isSuccess());
    }

    public function testArrayAccess()
    {
        $expect = [
            'status'    => true,
            'msg'       => 'hello',
            'a'         => 1,
            'b'         => 2,
            'time'      => date('Y-m-d H:i:s'),
        ];
        $result = Result::make($expect);

        $this->assertEquals($expect['a'],$result['a']);
        $this->assertTrue(isset($result['b']));

        $result['c'] = 3;
        $this->assertEquals(3, $result['c']);
        $this->assertEquals(3, $result->c);

        unset($result['c']);

        $this->assertEquals($expect,$result->toArray());

    }

}
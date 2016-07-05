<?php
/**
 * Date: 16/5/31
 * Time: 下午3:35
 */

namespace Xiaoshu\Foundation\Routing;


class BaseRoute
{
    protected $routeName;

    protected $attr = [];

    public function __construct($name)
    {
        $this->routeName = $name;
    }


    public function url($params = [])
    {
        return route($this->routeName,$params);
    }


    public function getName()
    {
        return $this->getRouteName();
    }

    public function getRouteName()
    {
        return $this->routeName;
    }

    public function getRequestAttr()
    {
        $parts = explode('::',$this->routeName,2);
        return count($parts)>1 ? $parts[0] : '';
    }

    public function getIndexAttr()
    {
        return $this->method === 'index';
    }

    public function getMethodAttr()
    {
        $secs = $this->secs;
        return end($secs) ? : '';
    }

    public function getSecsAttr()
    {
        $parts = explode('::',$this->routeName,2);
        if(count($parts) === 2){
            return explode('.',$parts[1]);
        }
        return [];
    }

    public function getGroupsAttr()
    {
        $secs   = $this->secs;
        $groups = [];
        for($i = 1; $i<count($secs); $i ++){
            $groups[] = implode('.',array_slice($secs,0,$i));
        }

        return $groups;
    }

    public function getPrefix()
    {
        $groups = $this->groups;
        return end($groups);
    }



    /*------------------------
     * magic
     -----------------------*/

    public function __get($name)
    {
        if(array_key_exists($name,$this->attr)){
            return $this->attr[$name];
        }

        $method = 'get'.ucfirst($name).'Attr';
        if(method_exists($this,$method)){
            return $this->attr[$name] = call_user_func_array([$this,$method],[]);
        }

        $method = 'get'.ucfirst($name);
        if(method_exists($this,$method)){
            return call_user_func_array([$this,$method],[]);
        }
    }

}

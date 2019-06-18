<?php
/**
 * Created by PhpStorm.
 * @author  jason <jasonwang1211@gmail.com>
 */

namespace Jsyqw\Utils\Traits;
use Closure;


trait Results
{
    static $CODE_SUCCESS = 0;                   //成功
    //1001 - 1999 客户端引起的错误
    static $CODE_ERROR_INVALID = 1002;          //非法请求
    static $CODE_ERROR_PARAMS = 1003;           //参数错误
    static $CODE_ERROR_SIGN = 1004;             //签名无效
    static $CODE_ERROR_AUTH = 1005;             //认证错误
    static $CODE_ERROR_TIME = 1006;             //时间校验失败
    //2000 - 2999 服务器的业务交互的错误提示
    static $CODE_ERROR_SERVER = 2000;           //服务器返回友好提示
    static $CODE_ERROR_UNKNOWN = 2001;          //未知错误
    static $CODE_ERROR_NOMORE = 2002;           //没有更多数据了
    static $CODE_ERROR_NOEXIST = 2003;          //暂无数据

    //3000 - 3999 服务器异常，以及错误处理 产生的错误

    static $CODE_ERROR_SERVICE = 3001;           //服务器错误

    //默认返回的消息
    protected static $defaultMsgList = [
        //成功
        0 =>    '操作成功',
        //1001 - 1999 客户端引起的错误
        1002 => '非法请求',//（post & get 请求不正确）
        1003 => '参数错误',//具体是什么参数错误，可以在返回的时候输入msg参数
        1004 => '签名无效',//--基类
        1005 => '认证错误',//token 无效--基类
        1006 => '请求无效',//（时间校验失败）--基类

        //2000 - 2999 服务器的业务交互的错误提示
        2000 => '服务器繁忙',    //服务器返回友好提示
        2001 => '未知错误',
        2002 => '没有更多数据了',//（针对列表式加载更多）
        2003 => '暂无数据',//数据不存在

        //3001 - 4000 服务器错误（用户自定义的错误，都应该在这个段）
        3001 => '服务器处理异常',
    ];

    /**
     * 定义返回json的数据
     *
     * @param $code
     * @param $msg
     * @param $data  必须是个数组对象， 即： key => value 的方式
     * @param $time  时间戳
     */
    protected $arrJson = [
        'code' => 0,
        'msg'  => '',
        'data' => [],
        'time' => 0
    ];

    /**
     * 响应 ajax 返回
     * @param null $array
     * @param Closure|null $callback  执行匿名函数，比如设置 header 头信息
     * @return array
     */
    public function returnJson($array = null, Closure $callback = null)
    {
        // 判断是否覆盖之前的值
        if ($array) {
            $this->arrJson = array_merge($this->arrJson, $array);
        }
        $code = $this->arrJson['code'];
        // 没有错误信息，就匹配默认的 code对应的 msg
        if (empty($this->arrJson['msg']) && isset(self::$defaultMsgList[$code])) {
            $this->arrJson['msg'] = self::$defaultMsgList[$code];
        }
        if(!$this->arrJson['time']){
            $this->arrJson['time'] = time();
        }
        if($callback && $callback instanceof Closure){
            $callback();
        }
        return $this->arrJson;
    }

    /**
     * 处理成功返回
     * @param array $data
     * @param string $msg
     * @param array $params
     * @param Closure|null $callback
     * @return array
     */
    public function success($data = [], $msg = '', $params = [], Closure $callback = null)
    {
        $arr = array_merge([
            'code' => self::$CODE_SUCCESS,
            'msg' => $msg,
            'data' => $data
        ], $params);
        return $this->returnJson($arr, $callback);
    }

    /**
     * 处理错误返回,参数错误
     * @param string $msg
     * @param array $params
     * @param Closure|null $callback
     * @return array
     */
    public function paramsError($msg = '', $params = [], Closure $callback = null)
    {
        $code = self::$CODE_ERROR_PARAMS;
        $arr = array_merge([
            'code' => $code,
            'msg' => $msg,
        ], $params);
        return $this->returnJson($arr, $callback);
    }

    /**
     * 处理错误返回
     * @param string $msg
     * @param int $code
     * @param array $params
     * @param Closure|null $callback
     * @return array
     */
    public function error($msg = '', $code = 2000, $params = [], Closure $callback = null)
    {
        $arr = array_merge([
            'code' => $code,
            'msg' => $msg,
        ], $params);
        return $this->returnJson($arr, $callback);
    }

    /**
     * 认证错误
     * @param string $msg
     * @param array $params
     * @param Closure|null $callback
     * @return array
     */
    public function authError($msg = '', $params = [], Closure $callback = null)
    {
        $arr = array_merge([
            'code' => self::$CODE_ERROR_AUTH,
            'msg' => $msg
        ], $params);
        return $this->returnJson($arr, $callback);
    }

    /**
     * 设置错误码
     *
     * @param int $code
     */
    public function setCode($code)
    {
        $this->arrJson['code'] = $code;
    }

    /**
     * 设置错误信息
     *
     * @param string $msg
     */
    public function setMsg($msg = '')
    {
        $this->arrJson['msg'] = $msg;
    }
}
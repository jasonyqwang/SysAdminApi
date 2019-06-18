<?php
/**
 * 关于Http 请求的助手类
 * @author  jason <jasonwang1211@gmail.com>
 */

namespace Jsyqw\Utils;

use Jsyqw\Utils\Exceptions\UtilsHttpException;

class HttpHelper
{
    /**
     * curl post 请求封装
     * @param $url
     * @param $data array|string
     * @param array $options
     * @return mixed
     * @throws UtilsHttpException
     */
    public static function curlPost($url, $data, $options = []){
        return self::curl('post',$url, $data, $options);
    }

    /**
     * @param $url
     * @param $data array|string
     * @param array $options
     * @return mixed
     */
    public static function curlGet($url, $data, $options = []){
        return self::curl('get',$url, $data, $options);
    }

    /**
     * @param $method
     * @param $url
     * @param $data
     * @param array $options
     * @return mixed
     * @throws UtilsHttpException
     */
    public static function curl($method, $url, $data='', $options = []){
        $method = strtolower($method);
        //由于 CURLOPT_POSTFIELDS 参数只支持一维数组参数，否则会出错，所以做次转换
        if(is_array($data)){
            $data = http_build_query($data);
        }
        if($method == 'get'){
            if(strpos($url, '?') === false){
                $url .= '?'.$data;
            }else{
                $url .= '&'.$data;
            }
        }
        $ch = curl_init($url);
        if(strpos($url, 'https') === 0){
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        if($method == 'post'){
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        //curl 参数的选项
        if($options){
            curl_setopt_array($ch, $options);
        }
        $ret = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if($error){
            throw new UtilsHttpException($error);
        }
        return $ret;
    }
}
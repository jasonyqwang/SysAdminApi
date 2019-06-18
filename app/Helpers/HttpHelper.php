<?php
/**
 * Created by PhpStorm.
 * 帮助类
 */

namespace App\Helpers;


class HttpHelper
{
    /**
     * @param $url
     * @param $data
     * @param array $options
     * @return bool|mixed
     */
    public static function curlPost($url, $data, $options = []){
        $ch = curl_init($url);

        if(strpos($url, 'https') === 0){
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);

        //curl 参数的选项
        if($options){
            curl_setopt_array($ch, $options);
        }

        $ret = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if($error){
            return false;
        }
        return $ret;
    }
}
<?php
/**
 * Created by PhpStorm.
 * @author  jason <jasonwang1211@gmail.com>
 */
namespace Jsyqw\Utils;

class ValidateHelper
{
    /**
     * Check phone rule
     * @param $phone
     * @return bool
     */
    public static function checkPhone($phone){
        if(preg_match("/^1[345789]{1}\d{9}$/",$phone)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Check email rule
     * @param $email
     * @return bool
     */
    public static function checkEmail($email){
        $pattern = "/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/";
        if(preg_match($pattern, $email)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Check it's an HTTP address or not
     * @param $str
     * @return bool
     */
    public static function isHttp($str){
        if(!$str){
            return false;
        }
        $pattern = '/(http|https):\/\/([\w.]+\/?)\S*/';
        if(preg_match($pattern, $str)){
            return true;
        }
        return false;
    }

    /**
     * 验证是否是 json 字符串
     * @param $str
     * @return bool
     */
    public static function isJson($str){
        json_decode($str);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}
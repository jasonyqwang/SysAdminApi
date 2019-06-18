<?php
/**
 * Created by PhpStorm.
 * 通用助手类
 */

namespace App\Helpers;


class CommonHelper
{
    public static function isJson($str){
        json_decode($str);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    public static function xy_init($key)
    {
        $len = strlen($key);
        $i =0;
        $j = 0;
        $k = [];
        $tmp = 0;
        for ($i=0;$i<256;$i++) {
            $s[$i] = $i;
            $k[$i] = isset($key[$i%$len]) ? $key[$i%$len] : 0;
        }
        for ($i=0; $i<256; $i++) {
            $j=($j+$s[$i]+ord($k[$i]))%256;
            $tmp = $s[$i];
            $s[$i] = $s[$j];
            $s[$j] = $tmp;
        }
        return $s;
    }

    public static function xy_crypt($s, $data)
    {
        $i = $j = $t = 0;
        $k = 0;
        $tmp = 0;
        $d = '';
        for($k=0;$k<strlen($data);$k++) {
            $i=($i+1)%256;
            $j=($j+$s[$i])%256;
            $tmp = $s[$i];
            $s[$i] = $s[$j];
            $s[$j] = $tmp;
            $t=($s[$i]+$s[$j])%256;
            $d .= chr(ord($data[$k]) ^ $s[$t]);
        }

        return $d;
    }

    /**
     * 加密
     * @param $data
     * @return string
     */
    public static function XyEncrypt($data){
        $key = "N!fRm1@v*^MP9AcrPBji^1lPsY#1rp!LeFew#aF1RcC$!KXFKeJt2!RU@0%Ic0Eq";
        $key = self::xy_init($key);
        $data=  base64_encode(self::xy_crypt($key,$data));//加密
        return $data;
    }

    /**
     * 解密
     * @param $data
     * @return mixed
     */
    public static function XyDecrypt($data){
        $key = "N!fRm1@v*^MP9AcrPBji^1lPsY#1rp!LeFew#aF1RcC$!KXFKeJt2!RU@0%Ic0Eq";
        $key = self::xy_init($key);
        $data=  self::xy_crypt($key, base64_decode($data));//解密
        return $data;
    }
}
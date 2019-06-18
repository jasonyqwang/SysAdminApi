<?php
/**
 * Created by PhpStorm.
 * @author  jason <jasonwang1211@gmail.com>
 */

namespace Jsyqw\Utils;


class FileHelper
{
    /**
     * Convert camel case to human readable format
     * @param $bytes
     * @param int $decimals
     * @return string
     */
    public static function format($bytes, $decimals = 2){
        $exp = 0;
        $value = 0;
        $symbol = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $bytes = (float)$bytes;
        if ($bytes > 0) {
            //换底公式 log(a)(x)=log(b)(x)/log(b)(a)
            $exp = floor(log($bytes) / log(1024));
            $value = $bytes / pow(1024, $exp);
        }
        if ($symbol[$exp] === 'B') {
            $decimals = 0;
        }
        return number_format($value, $decimals, '.', '') . '' . $symbol[$exp];
    }

    /**
     * Delete dir and files
     * @param $path
     * @param bool $isDelCurrent
     * @return bool
     */
    public static function delDir($path, $isDelCurrent = false){
        try{
            $path = trim($path, DIRECTORY_SEPARATOR);
            $path .= DIRECTORY_SEPARATOR;
            //如果是目录则继续
            if(is_dir($path)){
                //扫描一个文件夹内的所有文件夹和文件并返回数组
                $p = scandir($path);
                foreach($p as $val){
                    //排除目录中的.和..
                    if($val !="." && $val !=".."){
                        //如果是目录则递归子目录，继续操作
                        if(is_dir($path.$val)){
                            //子目录中操作删除文件夹和文件
                            self::delDir($path.$val.DIRECTORY_SEPARATOR);
                            //目录清空后删除空文件夹
                            rmdir($path.$val.DIRECTORY_SEPARATOR);
                        }else{
                            //如果是文件直接删除
                            unlink($path.$val);
                        }
                    }
                }
                if($isDelCurrent){
                    rmdir($path);
                }
            }
        }catch (\Exception $e){
            return false;
        }
        return true;
    }

    /**
     * Get files extension
     * 获取文件后缀
     * @param $str
     * @return mixed|string
     */
    public static function getExt($str){
        $ext = pathinfo($str,PATHINFO_EXTENSION);
        if(!$ext){
            return $ext;
        }
        return strtolower(trim($ext));
    }

}
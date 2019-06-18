<?php
/**
 * Created by PhpStorm.
 * @author: jason
 */
namespace Jsyqw\PHPUnit;

//config the project base path
defined('BASE_PATH') ?: define('BASE_PATH', dirname(__DIR__));

$autoloadFile = BASE_PATH.'/vendor/autoload.php';
if(!file_exists($autoloadFile)){
    echo '请先安装 composer 依赖包'.PHP_EOL;
    exit();
}
require_once $autoloadFile;




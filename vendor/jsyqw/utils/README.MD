# 实用工具包

# 安装

    composer require jsyqw/utils
    
## 数组助手类 ArrayHelper
```php

//把对象或者数组对象，转成数组
ArrayHelper::toArray($object, $properties = [], $recursive = true);

//获取对象或者数组的指定的值
ArrayHelper::getValue($array, $key, $default = null);

//根据指定的key，建立key对应索引的数组，或者分组后的索引数组
ArrayHelper::index($array, $key, $groups = []);

//把数组转成 key-value 的形式
ArrayHelper::map($array, $from, $to, $group = null);

//检查数组是否是列索引
ArrayHelper::isAssoc($array);
    
```

## FileHelper
```php

//Convert camel case to human readable format
FileHelper::format($bytes, $decimals = 2);

//Delete dir and files
FileHelper::delDir($path, $isDelCurrent = false);

//Get files extension
FileHelper::getExt($str);

```

## IPHelper
```php

//Get client`s real ip
IPHelper::remoteIp($useProxy = false)

//Generate  random chinese`ip
IPHelper::randIp()

```

## StrHelper
```php

//生成唯一数字 eg: YYYYMMDDHHIISSNNNNNNNNCC 24 
StrHelper::uniqueNum();

//生成唯一的 guid
StrHelper::guid();

//随机字长度的随机字符串
StrHelper::random($length = 6, $type = 'string')

```

## ValidateHelper
```php

//Check phone rule
ValidateHelper::checkPhone($phone);

//Check email rule
ValidateHelper::checkEmail($email);

//Check it's an HTTP address or not
ValidateHelper::isHttp($str);

//验证是否是 json 字符串
ValidateHelper::isJson($str)

```
## HttpHelper
```php

//curl post 请求封装
HttpHelper::curlPost($url, $data, $options = [])

//curl get 请求封装
HttpHelper::curlGet($url, $data, $options = [])

//curl 请求封装
curl($method, $url, $data='', $options = [])

```


## Results 处理结果类的封装

* 一般用于返回统一格式的时候使用（API）
* 使用的模式三种
    
    1.Trait方式引入 ,在 Class 中引入 use Jsyqw\Utils\Traits\Results
    
    2.面板方式引入 Jsyqw\Utils\Facades\Results  参考laravel的面板设计
    
    3.对象方式引入 new Jsyqw\Utils\Results
*  返回结果默认格式定义如下  
```php

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

```
* 调用方法
```php

    Jsyqw\Utils\Facades\Results::returnJson($array = null);
    
    Jsyqw\Utils\Facades\Results::success($data = [], $msg = '', $params = []);
    
    Jsyqw\Utils\Facades\Results::paramsError($msg = '', $params = []);
    
    Jsyqw\Utils\Facades\Results::error($msg = '', $code = 2000, $params = []);
    
    Jsyqw\Utils\Facades\Results::authError($params = []);
    
    Jsyqw\Utils\Facades\Results::setCode($code);
    
    Jsyqw\Utils\Facades\Results::setMsg($msg = '');
    
    //返回格式： 
    [
        'code' => 0,
        'msg'  => '',
        'data' => [],
        'time' => 0
    ]
    
```



    
        
    
    
    
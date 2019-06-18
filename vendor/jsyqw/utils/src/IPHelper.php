<?php
/**
 * Created by PhpStorm.
 * @author  jason <jasonwang1211@gmail.com>
 */

namespace Jsyqw\Utils;


class IPHelper
{
    /**
     * Get client`s real ip
     * @param bool $useProxy 是否使用代理的ip (有代理的情况下)
     * @link
     * @return string
     */
    public static function remoteIp($useProxy = false){
        if (!$useProxy) {
            //REMOTE_ADDR: 是你的客户端跟你的服务器“握手”时候的IP。如果使用了“匿名代理”，REMOTE_ADDR将显示代理服务器的IP。
            return $_SERVER['REMOTE_ADDR'];
        }
        $ip = '';
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            //HTTP_CLIENT_IP 【可以伪造】是代理服务器发送的HTTP头。如果是“超级匿名代理”，则返回none值。同样，REMOTE_ADDR也会被替换为这个代理服务器的IP。
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_REAL_IP'])) {
            //【不可伪造】需要配置，比如nginx代理中 proxy_set_header X-Real-IP $remote_addr;
            $ip = $_SERVER['HTTP_X_REAL_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //【可以伪造】用户是在哪个IP使用的代理（有可能存在，也可以伪造） 如果存在，取第一个即可
            $proxyIp =explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $ip = $proxyIp[0];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    /**
     * Generate  random chinese`ip
     * @return string
     */
    public static function randIp(){
        //ip2long($ip)把ip转为int
        //long2ip($int_ip)把int转回ip
        $ipLong = [
            ['607649792', '608174079'], //36.56.0.0-36.63.255.255
            ['1038614528', '1039007743'], //61.232.0.0-61.237.255.255
            ['1783627776', '1784676351'], //106.80.0.0-106.95.255.255
            ['2035023872', '2035154943'], //121.76.0.0-121.77.255.255
            ['2078801920', '2079064063'], //123.232.0.0-123.235.255.255
            ['-1950089216', '-1948778497'], //139.196.0.0-139.215.255.255
            ['-1425539072', '-1425014785'], //171.8.0.0-171.15.255.255
            ['-1236271104', '-1235419137'], //182.80.0.0-182.92.255.255
            ['-770113536', '-768606209'], //210.25.0.0-210.47.255.255
            ['-569376768', '-564133889'] //222.16.0.0-222.95.255.255
        ];
        $randKey = mt_rand(0, 9);
        $ip= long2ip(mt_rand($ipLong[$randKey][0], $ipLong[$randKey][1]));
        return $ip;
    }
}
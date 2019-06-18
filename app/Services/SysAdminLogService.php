<?php
/**
 * Created by PhpStorm.
 */

namespace App\Services;

use App\Models\SysAdminLog;
use Illuminate\Support\Facades\Facade;
use Jsyqw\Utils\IPHelper;

class SysAdminLogService extends Facade
{
    /**
     * @var SysAdminLog
     */
    private static $_log;

    /**
     * 获取 SysAdminLog 单例
     * @return SysAdminLog
     */
    public static function logInstance(){
        if(!self::$_log){
            self::$_log = new SysAdminLog();
        }
        return self::$_log;
    }

    /**
     * 保存数据
     * @param array $data
     * @return bool
     */
    public static function initRequestData(array $data = []){
        $request = request();
        $log = self::logInstance();
        // 从中间件中获取用户信息
        $userInfo = $request->get('mid_userInfo');
        $log->sys_user_id = $userInfo ? $userInfo['id'] : 0;
        $log->type = 1;
        $log->ip = IPHelper::remoteIp(false);
        $log->api_name = $request->path();
        $log->request_method = $request->method();
        $log->request_header = json_encode($request->header(), JSON_UNESCAPED_UNICODE);
        $log->request_get = json_encode($request->query(), JSON_UNESCAPED_UNICODE);
        $log->request_post = json_encode($request->post(), JSON_UNESCAPED_UNICODE);
        $log->response_content = '';
        $log->remark = '';
        $log->create_time = time();
        $log->update_time = time();
        $log->save();

        $log = self::logInstance();
        foreach ($data as $k => $v){
            $log->$k = $v;
        }
        return $log->save();
    }

    /**
     * 更新返回信息
     * @param $responseContent
     * @param array $data
     * @return bool
     */
    public static function update($responseContent, $data = []){
        $log = self::logInstance();
        if(!$log->api_name){
            self::initRequestData($data);
        }
        if(is_array($responseContent)){
            $responseContent = json_encode($responseContent, JSON_UNESCAPED_UNICODE);
        }
        $log->response_content = $responseContent;
        foreach ($data as $k => $v){
            $log->$k = $v;
        }
        $log->update_time = time();
        return $log->save();
    }

}
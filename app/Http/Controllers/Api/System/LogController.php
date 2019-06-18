<?php

namespace App\Http\Controllers\Api\System;

use App\Http\Controllers\Api\BaseController;
use App\Models\CplusApiLog;
use App\Models\SysAdminLog;
use Illuminate\Http\Request;

class LogController extends BaseController
{
    /**
     * 后台操作日志列表
     * @param Request $request
     * @return mixed
     */
    public function sysLog(Request $request){
        $currentPage = $request->get('currentPage', 1);
        $pageSize = $request->get('pageSize', 10);
        $key = $request->get('key', '');
        $startTime = $request->get('startTime', '');
        $endTime = $request->get('endTime', '');
        $offset = ($currentPage-1) * $pageSize;

        $query = SysAdminLog::query();
        $query->select(['sys_admin_log.*', 'sys_user.username']);
        $query->leftJoin('sys_user', 'sys_admin_log.sys_user_id', '=', 'sys_user.id');
        if($key){
            $query->where('sys_admin_log.api_name', 'like', "$key%");
        }
        if($startTime){
            $query->where('sys_admin_log.create_time', '>=', strtotime($startTime));
        }
        if($endTime){
            $query->where('sys_admin_log.create_time', '<', strtotime($endTime));
        }
        $lists = $query
            ->limit($pageSize)
            ->offset($offset)
            ->orderBy('sys_admin_log.create_time', 'desc')
            ->get()
            ->toArray();

        return $this->success([
            'lists' => $lists
        ]);
    }
}

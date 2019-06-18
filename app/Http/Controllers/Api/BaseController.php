<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Jsyqw\Utils\Traits\Results;

class BaseController extends Controller
{
    use Results;

    protected function resJson($msg, $status, $data){
        $data = array('message'=>$msg,'status'=>$status,'data'=>$data);
        return Response::json($data);
    }

    /**
     * 成功返回
     * @param $data
     * @param string $msg
     * @return string
     */
    protected function resSuccess($data = [], $msg = '成功'){
        return $this->resJson($msg, 1, $data);
    }

    /**
     * 返回错误信息
     * @param $msg
     * @param int $status
     * @param array $data
     * @return string
     */
    protected function resError($msg, $status = 0, $data = []){
        return $this->resJson($msg, $status, $data);
    }
}

<?php

namespace App\Http\Controllers\Api\System;

use App\Http\Controllers\Api\BaseController;
use App\Models\SysRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RuleController extends BaseController
{
    /**
     * 删除权限
     * @param Request $request
     */
    public function delete(Request $request){
        $id = $request->get('id');
        if(!$id){
            return $this->paramsError('参数有误');
        }
        $model = SysRule::find($id);
        if(!$model){
            return $this->paramsError('权限不存在');
        }
        //判断是否存在子类
        $subModel = SysRule::wherePid($id)->first();
        if($subModel){
            return $this->paramsError('该权限有子集，不能直接删除');
        }
        $ret = $model->delete();
        if(!$ret){
            return $this->error('操作失败');
        }
        return $this->success();
    }

    /**
     * 权限列表
     * @param Request $request
     * @return array
     */
    public function treeLists(Request $request){
        $key = $request->get('key', '');
        $menu = $request->get('menu', '');
        $status = $request->get('status', '');

        $query = DB::table('sys_rule');
        if($key){
            $query->where('name', 'like', "%$key%");
            $query->orWhere('label', 'like', "%$key%");
        }
        if(is_numeric($menu)){
            $query->where('menu', $menu);
        }
        if(is_numeric($status)){
            $query->where('status', $status);
        }
        $lists = $query->orderBy('sort', 'desc')
            ->get()->map(function ($value){
                return (array)$value;
            })
            ->toArray();
        $lists = SysRule::getRuleTree($lists, 0);

        return $this->success([
            'lists' => $lists
        ]);
    }

    /**
     * 保存权限
     */
    public function save(Request $request)
    {
        $form = $request->get('form');
        $id = $form['id'];
        if($id && isset($form['pid']) && $id == $form['pid']){
            return $this->error('不能选择自己作为父级');
        }
        unset($form['id']);
        $form['update_time'] = time();
        $form['status'] = (int)$form['status'];
        if(!$id) {
            $model = SysRule::query()->where('name', $form['name'])->first();
        }else{
            $model = SysRule::query()->where('id', $id)->first();
        }
        if(!$model) {
            $form['create_time'] = time();
            $model = new SysRule();
        }

        $ret = $model->saveData($form);
        if(!$ret){
            return $this->error('保存失败');
        }
        return $this->success($ret);
    }

    /**
     * 获取所有的路由，用户提示信息
     * @return mixed
     */
    public function allRoutes()
    {
        $routes = app()->routes->getRoutes();
        $data = [];
        foreach ($routes as $value) {
            if(!$value->uri || $value->uri === '/') {
                continue;
            }
            $data[] = $value->uri;
        }

        return $this->success([
            'lists' => $data
        ]);
    }
}

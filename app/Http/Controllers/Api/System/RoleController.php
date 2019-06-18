<?php

namespace App\Http\Controllers\Api\System;

use App\Http\Controllers\Api\BaseController;
use App\Models\SysRole;
use App\Models\SysRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jsyqw\Utils\ArrayHelper;

class RoleController extends BaseController
{

    /**
     * 下拉框列表
     * @param Request $request
     * @return array
     */
    public function dicts(Request $request){
        $lists = SysRole::query()->select([
            'id',
            'name',
        ])->where('status', '=', 1)
            ->get()
            ->toArray();
        $lists = ArrayHelper::map($lists, 'id', 'name');
        return $this->success(['lists' => $lists]);
    }

    /**
     * 角色列表
     * @param Request $request
     * @return array
     */
    public function lists(Request $request){
        $currentPage = $request->get('currentPage', 1);
        $pageSize = $request->get('pageSize', 10);
        $key = $request->get('key', '');
        $offset = ($currentPage-1) * $pageSize;

        $lists = SysRole::query()->select([
            'id',
            'status',
            'name',
            'description',
            'create_time'
        ])->where('name', 'like', "%$key%")
            ->limit($pageSize)
            ->offset($offset)
            ->get()
            ->toArray();

        return $this->success([
            'lists' => $lists
        ]);
    }

    // 编辑添加角色
    public function edit(Request $request){
        $form = $request->get('form');
        if(!$form['name']){
            return $this->paramsError('角色名不能为空');
        }

        if (isset($form['id'])) {
            $id = $form['id'];
            unset($form['id']);
            $form['update_time'] = time();
            $ret = SysRole::where('id',$id)->update($form);
        } else {
            $form['create_time'] = $form['update_time'] = time();
            $ret = SysRole::create($form);
        }
        if(!$ret){
            return $this->error('操作失败');
        }
        return $this->success();
    }

    // 删除角色
    public function delete(Request $request){
        $id = $request->get('id');
        $ret = false;
        if ($id) {
            $ret = SysRole::where('id',$id)->delete();
        }
        if(!$ret){
            return $this->error('删除失败');
        }
        return $this->success();
    }

    /**
     * 获取角色的权限
     * @param Request $request
     * @return array
     */
    public function getRoleRulesTree(Request $request){
        $roleId = $request->get('role_id');
        if(!$roleId){
            return $this->paramsError('缺少角色参数');
        }
        $query = DB::table('sys_rule');
        $lists = $query->orderBy('sort', 'desc')
            ->get()
            ->map(function ($value){
                return (array)$value;
            })
            ->toArray();

        $roleRuleList = SysRole::getRoleRules($roleId);
        $checkedKeys = array_column($roleRuleList, 'id');
        $lists = SysRule::getRuleTree($lists, 0);

        return $this->success([
            'lists' => $lists,
            'checkedKeys' => $checkedKeys
        ]);
    }


    /**
     * 保存角色权限
     * @param Request $request
     * @return array
     */
    public function saveRoleRules(Request $request){
        $form = $request->get('form');
        if(!$form['role_id']){
            return $this->paramsError('参数有误');
        }
        $roleId = $form['role_id'];
        $data = [];
        foreach ($form['rules'] as $ruleId){
            $data[] = [
                'role_id' => $roleId,
                'rule_id' => $ruleId,
            ];
        }
        DB::beginTransaction();
        try{
            DB::table('sys_role_rule')->where([
                'role_id' => $roleId
            ])->delete();

            if($data){
                DB::table('sys_role_rule')->insert($data);
            }
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            return $this->error($e->getMessage());
        }
        return $this->success();
    }

    /**
     * 获取角色的菜单
     * @param Request $request
     * @return array
     */
    public function getRoleMenusTree(Request $request){
        //
        $userInfo = $request->get('mid_userInfo');
        $roleId = $userInfo['role_id'];
        if(!$roleId){
            return $this->authError();
        }
        //获取 h5 页面的菜单
        $lists = SysRole::getRoleRules($roleId, ['status' => 1, 'type' => 0]);
        $lists = SysRule::getMenusTree($lists, 0);
        return $this->success([
            'lists' => $lists,
        ]);
    }
}

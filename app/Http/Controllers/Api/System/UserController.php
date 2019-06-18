<?php

namespace App\Http\Controllers\Api\System;

use App\Http\Controllers\Api\BaseController;
use App\Models\SysUser;
use App\Services\SysAdminLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Jsyqw\Utils\StrHelper;

class UserController extends BaseController
{
    public function __construct()
    {
        //设置 需要记录日志的接口
        $this->middleware('sys.operation.log', ['expect' => [
            'lists'
        ]]);
    }

    /**
     * 修改密码
     * @param Request $request
     */
    public function upUserPwd(Request $request)
    {
        $id = $request->get('id');
        $password = $request->get('password');
        if (!$id || !$password) {
            return $this->paramsError('参数有误');
        }
        $model = SysUser::find($id);
        if (!$model) {
            return $this->paramsError('用户不存在');
        }
        //删除状态
        $model->token = '';
        $model->password = Hash::make($password);;
        $model->update_time = time();
        $ret = $model->save();
        if (!$ret) {
            return $this->error('操作失败');
        }
        return $this->success();
    }

    /**
     * 登录
     * @param Request $request
     * @return array
     */
    public function login(Request $request)
    {
        $username = $request->get('username');
        $password = $request->get('password');
        if (!$username && !$password) {
            return $this->error('参数有误');
        }
        $userModel = SysUser::where([
            'username' => $username
        ])->first();
        if (!$userModel) {
            return $this->error('用户名或密码有误！');
        }
        //账号状态 -1:刪除 1:正常 2:禁止登陆
        if (-1 == $userModel->status) {
            return $this->error('账号已删除！');
        }
        if (2 == $userModel->status) {
            return $this->error('该账号禁止登陆！');
        }
        if (1 != $userModel->status) {
            return $this->error('账号异常');
        }
        $dbPassword = $userModel->password;
        if (!Hash::check($password, $dbPassword)) {
            return $this->error('用户名或密码有误');
        }
        $userModel->token = StrHelper::guid();
        $userModel->token_time = time();
        if (!$userModel->save()) {
            return $this->error('服务异常');
        }
        $data = $this->success([
            'username' => $userModel->username,
            'role_id' => $userModel->role_id,
            'token' => $userModel->token,
            'last_login_time' => $userModel->last_login_time,
            'last_ip' => $userModel->last_ip,
        ]);

        //记录更新日志返回值
        SysAdminLogService::update($data, [
            'sys_user_id' => $userModel->id
        ]);

        return $data;
    }

    /**
     * 创建用户
     * @param Request $request
     * @return array
     */
    public function create(Request $request)
    {
        $form = $request->get('form');
        if (!$form['username']) {
            return $this->paramsError('用户名不能为空');
        }
        if (!$form['password']) {
            return $this->paramsError('密码不能为空');
        }
        if ($form['password'] != $form['repeat_password']) {
            return $this->paramsError('两次密码不一致');
        }
        unset($form['repeat_password']);

        //初始化数据
        $form['password'] = Hash::make($form['password']);
        $form['create_time'] = time();
        $form['update_time'] = time();

        $ret = SysUser::create($form);
        if (!$ret) {
            return $this->error('添加失败');
        }
        return $this->success();
    }

    /**
     * 删除用户
     * @param Request $request
     */
    public function delete(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return $this->paramsError('参数有误');
        }
        if($id == 1){
            //todo
            return $this->error('禁止删除');
        }
        $model = SysUser::find($id);
        if (!$model) {
            return $this->paramsError('用户不存在');
        }
        //删除状态
        $model->status = -1;
        $model->update_time = time();
        $ret = $model->save();
        if (!$ret) {
            return $this->error('操作失败');
        }
        return $this->success();
    }

    /**
     * 编辑用户
     * @param Request $request
     * @return array
     */
    public function edit(Request $request)
    {
        $form = $request->get('form');
        if (!($id = $form['id'])) {
            return $this->paramsError('参数有误');
        }
        $model = SysUser::find($id);
        if (!$model) {
            return $this->paramsError('用户不存在');
        }
        //初始化数据
        $model->mobile = $form['mobile'];
        $model->realname = $form['realname'];
        $model->role_id = $form['role_id'];
        $model->status = $form['status'];
        $model->update_time = time();

        $ret = $model->save();
        if (!$ret) {
            return $this->error('修改失败');
        }
        return $this->success();
    }

    /**
     * 用户列表
     * @param Request $request
     * @return array
     */
    public function lists(Request $request)
    {
        $currentPage = $request->get('currentPage', 1);
        $pageSize = $request->get('pageSize', 10);
        $key = $request->get('key', '');
        $offset = ($currentPage - 1) * $pageSize;

        $lists = SysUser::select([
            'sys_user.id',
            'sys_user.status',
            'sys_user.username',
            'sys_user.realname',
            'sys_user.role_id',
            DB::raw('sys_role.name as role_name'),
            'sys_user.avatar',
            'sys_user.email',
            'sys_user.mobile',
            'sys_user.create_time'
        ])->leftJoin('sys_role', 'role_id', '=', 'sys_role.id')
            ->where('sys_user.username', 'like', "%$key%")
            ->where('sys_user.status', '>', 0)
            ->limit($pageSize)
            ->offset($offset)
            ->get()
            ->toArray();

        return $this->success([
            'lists' => $lists
        ]);
    }
}

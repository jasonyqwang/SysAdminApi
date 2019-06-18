<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//登录接口
Route::post('system/user/login', 'Api\System\UserController@login');

Route::namespace('Api')->middleware(['api.auth.token'])->group(function () {
    //后台模块
    Route::namespace('System')->group(function () {
        //用户
        Route::prefix('system/user')->group(function () {
            //添加用户
            Route::post('create', 'UserController@create');
            //删除用户
            Route::post('delete', 'UserController@delete');
            //编辑用户
            Route::post('edit', 'UserController@edit');
            //用户列表
            Route::get('lists', 'UserController@lists');
            //修改密码
            Route::post('upUserPwd', 'UserController@upUserPwd');
        });
        //权限
        Route::prefix('system/rule')->group(function () {
            //添加
            Route::post('save', 'RuleController@save');
            //删除
            Route::post('delete', 'RuleController@delete');
            //列表
            Route::get('treeLists', 'RuleController@treeLists');
            //返回所有的路由
            Route::get('allRoutes', 'RuleController@allRoutes');
        });
        //角色
        Route::prefix('system/role')->group(function () {
            //下拉框列表接口
            Route::get('dicts', 'RoleController@dicts');
            //角色列表
            Route::get('lists', 'RoleController@lists');
            // 编辑角色
            Route::post('edit', 'RoleController@edit');
            // 删除角色
            Route::post('delete', 'RoleController@delete');
            // 保存角色权限
            Route::post('saveRoleRules', 'RoleController@saveRoleRules');
            //获取角色权限树
            Route::get('getRoleRulesTree', 'RoleController@getRoleRulesTree');
            //获取菜单
            Route::get('getRoleMenusTree', 'RoleController@getRoleMenusTree');
        });

        //接口日志列表
        Route::prefix('system/log')->group(function () {
            //列表
            Route::get('lists', 'LogController@lists');
            Route::get('sysLog', 'LogController@sysLog');
        });
    });
});

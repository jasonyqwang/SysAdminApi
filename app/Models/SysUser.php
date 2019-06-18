<?php

namespace App\Models;

/**
 * App\Models\SysUser
 *
 * @property int $id 自增ID
 * @property int $status 账号状态 -1:刪除 1:正常 2:禁止登陆
 * @property string $username 用户名
 * @property string $password 密码
 * @property string $realname 真实姓名
 * @property int|null $role_id 角色
 * @property string|null $avatar 用户头像
 * @property string|null $email 电子邮箱
 * @property string|null $mobile 手机号
 * @property string|null $token 用户的token
 * @property int|null $token_time Token生成时间
 * @property int|null $last_login_time 最后登录时间
 * @property string $last_ip 最后登录IP
 * @property int $create_time 数据插入时间
 * @property int|null $update_time
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysUser whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysUser whereCreateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysUser whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysUser whereLastIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysUser whereLastLoginTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysUser whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysUser wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysUser whereRealname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysUser whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysUser whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysUser whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysUser whereTokenTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysUser whereUpdateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysUser whereUsername($value)
 * @mixin \Eloquent
 */
class SysUser extends BaseModel
{
    public $table = 'sys_user';
}

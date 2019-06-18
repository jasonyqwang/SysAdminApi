<?php

namespace App\Models;


use Illuminate\Support\Facades\DB;

/**
 * App\Models\SysRole
 *
 * @property int $id 自增ID
 * @property string $name 组名称
 * @property int $status 状态  0 禁用，1 启用
 * @property string|null $description 描述
 * @property int|null $create_time 创建时间
 * @property int|null $update_time 更新时间
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysRole query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysRole whereCreateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysRole whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysRole whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysRole whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysRole whereUpdateTime($value)
 * @mixin \Eloquent
 */
class SysRole extends BaseModel
{
    //管理员的角色id
    const ADMIN_ROLE_ID = 1;
    public $table = 'sys_role';

    /**
     * 获取角色的权限
     * @param $roleId
     * @param array $condition ["menu" => 1, "status" => 1, "type" => 1]
     * @return array
     */
    public static function getRoleRules($roleId, $condition = []){
        $query = DB::table('sys_rule');
        $query->select(['sys_rule.*']);
        if(isset($condition['menu'])){
            $query->where('sys_rule.menu', $condition['menu']);
        }
        if(isset($condition['status'])){
            $query->where('sys_rule.status', $condition['status']);
        }
        if(isset($condition['type'])){
            $query->where('sys_rule.type', $condition['type']);
        }
        //超级管理员的话，需要查询所有的权限
        if($roleId == self::ADMIN_ROLE_ID){
            $lists = $query
                ->orderBy('sys_rule.sort', 'desc')
                ->get()
                ->map(function ($value){
                    return (array)$value;
                })
                ->toArray();
        }else{
            $lists = $query
                ->join('sys_role_rule', 'sys_rule.id', '=', 'sys_role_rule.rule_id')
                ->where('sys_role_rule.role_id', $roleId)
                ->orderBy('sys_rule.sort', 'desc')
                ->get()
                ->map(function ($value){
                    return (array)$value;
                })
                ->toArray();
        }
        return $lists;
    }
}

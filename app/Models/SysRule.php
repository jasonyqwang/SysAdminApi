<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

/**
 * App\Models\SysRule
 *
 * @property int $id 自增ID
 * @property int $pid 父级ID
 * @property string|null $name 权限点
 * @property string $title 名称
 * @property int $status 1 启用; 0 禁用
 * @property int $menu 1 作为菜单显示; 0 不显示
 * @property int|null $type 权限类型 0:h5页面 1:接口权限
 * @property string|null $condition
 * @property string|null $remark 备注
 * @property string|null $icon 菜单的图标
 * @property int|null $sort 菜单排序(降序)
 * @property int|null $create_time 创建时间
 * @property int|null $update_time 创建时间
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysRule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysRule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysRule query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysRule whereCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysRule whereCreateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysRule whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysRule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysRule whereMenu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysRule whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysRule wherePid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysRule whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysRule whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysRule whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysRule whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SysRule whereUpdateTime($value)
 * @mixin \Eloquent
 */
class SysRule extends BaseModel
{
    public $table = 'sys_rule';

    /**
     * 保存数据
     * @param $params
     * @return bool
     */
    public function saveData($params)
    {
        foreach ($params as $key => $value) {
            $this->{$key} = $value;
        }

        return $this->save();
    }

    /**
     * 生成菜单树
     * @param $list
     * @param $pid
     * @return array
     */
    public static function getRuleTree($list, $pid)
    {
        $tree = [];
        foreach ($list as $row) {
            if($row['pid'] === $pid) {
                $children = self::getRuleTree($list, $row['id']);
                if(!empty($children)) {
                    $row['children'] = $children;
                }
                $tree[] = $row;
            }
        }
        return $tree;
    }

    /**
     * 转成 菜单的格式
     * @param $list
     * @param $pid
     * @return array
     * [{
        "id": 18,
        "pid": 0,
        "name": "functions",
        "label": "功能管理",
        "menu": 1,
        "icon": "el-icon-setting",
        "children": []
     }]
     */
    public static function getMenusTree($list, $pid)
    {
        $tree = [];
        foreach ($list as $row) {
            if($row['pid'] === $pid) {
                $temp = [
                    'id' => $row['id'],
                    'pid' => $row['pid'],
                    'name' => '/'.trim($row['name'], '/'),
                    'label' => $row['label'],
                    'menu' => $row['menu'],
                    'icon' => $row['icon'],
                ];
                $children = self::getMenusTree($list, $row['id']);
                if(!empty($children)) {
                    $temp['children'] = $children;
                }
                $tree[] = $temp;
            }
        }
        return $tree;
    }
}

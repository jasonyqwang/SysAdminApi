<?php

namespace App\Models;

/**
 * App\Models\CplusApiLog
 *
 * @property int $id
 * @property string|null $url 接口地址
 * @property string|null $name 接口名称
 * @property string|null $params 请求参数
 * @property string|null $request_params_encrypt 请求的加密
 * @property int|null $response_status 返回状态
 * @property string|null $response_message 返回 message
 * @property string|null $response_content 接口返回内容
 * @property string|null $response_content_encrypt 返回的加密信息
 * @property float|null $consum_time 消耗时间
 * @property string|null $remark 备注
 * @property int|null $create_time 创建时间
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CplusApiLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CplusApiLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CplusApiLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CplusApiLog whereConsumTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CplusApiLog whereCreateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CplusApiLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CplusApiLog whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CplusApiLog whereParams($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CplusApiLog whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CplusApiLog whereRequestParamsEncrypt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CplusApiLog whereResponseContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CplusApiLog whereResponseContentEncrypt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CplusApiLog whereResponseMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CplusApiLog whereResponseStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CplusApiLog whereUrl($value)
 * @mixin \Eloquent
 */
class CplusApiLog extends BaseModel
{
    public $table = 'cplus_api_log';
}

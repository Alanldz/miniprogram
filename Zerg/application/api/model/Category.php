<?php
/**
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/9/11
 * Time: 19:39
 */

namespace app\api\model;


class Category extends BaseModel
{
    //隐藏字段
    protected $hidden = ['delete_time','update_time'];

    /**
     * 关联image表
     * @return \think\model\relation\BelongsTo
     * @author ldz
     * @time 2019/10/12 17:23
     */
    public function img(){
        return $this->belongsTo('Image','topic_img_id','id');
    }
}
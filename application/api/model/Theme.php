<?php
/**
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/8/13
 * Time: 21:26
 */

namespace app\api\model;


class Theme extends BaseModel
{
    //隐藏不显示字段
    protected $hidden = ['delete_time','update_time','topic_img_id','head_img_id'];

    /**
     * 关联主题图片
     * @return \think\model\relation\BelongsTo
     * @author ldz
     * @time 2019-8-21 19:36:40
     */
    public function topicImg(){
        return $this->belongsTo('Image','topic_img_id','id');
    }

    /**
     * 关联专题列表页图片
     * @return \think\model\relation\BelongsTo
     * @author ldz
     * @time 2019-8-21 19:37:01
     */
    public function headImg(){
        return $this->belongsTo('Image','head_img_id','id');
    }


}
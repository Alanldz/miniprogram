<?php

namespace app\api\model;

class BannerItem extends BaseModel
{
    protected $hidden = ['id','img_id','banner_id','delete_time','update_time'];

    /**
     * 关联image
     * @author ldz
     * @time 2019-8-8 20:37:58
     */
    public function img(){
        return $this->belongsTo('image','img_id','id');
    }
}

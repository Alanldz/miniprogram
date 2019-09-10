<?php

namespace app\api\model;

use think\Model;

class BaseModel extends Model
{
    /**
     * 补充完整图片路径
     * @param $value
     * @param $data
     * @return string
     * @author ldz
     * @time 2019-9-10 19:59:21
     */
    protected function prefixImgUrl($value,$data){
        $finalUrl = $value;
        if($data['from'] == 1){
            $finalUrl = config('setting.img_prefix').$value;
        }
        return $finalUrl;
    }
}

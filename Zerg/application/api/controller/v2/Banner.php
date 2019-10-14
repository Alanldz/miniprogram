<?php
/**
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/7/22
 * Time: 20:16
 */

namespace app\api\controller\v2;

use app\api\model\Banner as BannerModel;
use app\api\validate\IDMustBePostLiveInt;
use app\lib\exception\BannerMissException;

class Banner
{

    public function getBanner($id){
       return 'this is version2';
    }

}
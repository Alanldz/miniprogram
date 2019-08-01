<?php
/**
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/7/22
 * Time: 20:16
 */

namespace app\api\controller\v1;

use app\api\model\Banner as BannerModel;
use app\api\validate\IDMustBePostLiveInt;
use app\lib\exception\BannerMissException;

class Banner
{
    /**
     * 获取指定id的banner信息
     * @url /banner/:id
     * @http GET
     * @id banner的id号
     *
     * @param int $id
     * @author ldz
     * @throws \think\Exception
     * @time 2019-7-24 09:10:36
     * @return \think\response\Json
     */
    public function getBanner($id){
        //AOP 面向切面编程
        (new IDMustBePostLiveInt())->goCheck();
        $banner = BannerModel::getBannerByID($id);
        if(!$banner){
            throw new BannerMissException();
        }
        return json($banner);
    }

}
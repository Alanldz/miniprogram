<?php
/**
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/8/13
 * Time: 21:22
 */
namespace app\api\Controller\v1;

use app\api\model\Theme as ThemeModel;
use app\api\validate\IDCollection;
use app\lib\exception\ThemeException;

class Theme {

    /**
     * @param string $ids
     * @URL /theme?ids=id1,id2,id3,id4......
     * @return \think\response\Json 一组theme模型
     *
     * @author ldz
     * @throws \think\Exception
     * @time 2019-8-19 17:59:19
     */
    public function getSimpleList($ids = ''){
        (new IDCollection())->goCheck();
        $ids = explode(',',$ids);

        $result = ThemeModel::with('topicImg,headImg')->select($ids);
        if(!$result){
            throw new ThemeException();
        }
        return json($result);
    }

}
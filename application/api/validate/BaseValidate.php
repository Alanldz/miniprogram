<?php
/**
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/7/23
 * Time: 20:22
 */

namespace app\api\validate;

use app\lib\exception\ParameterException;
use think\Exception;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    /**
     * @return bool
     * @throws Exception
     * @author ldz
     * @time 2019-7-23 20:24:56
     */
    public function goCheck(){
        $request = Request::instance();
        $params = $request->param();
        $result = $this->batch()->check($params);
        if(!$result){
            $e = new ParameterException(['msg'=>$this->error]);
            throw $e;
        }else{
            return true;
        }
    }

}
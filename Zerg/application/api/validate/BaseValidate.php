<?php
/**
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/7/23
 * Time: 20:22
 */

namespace app\api\validate;

use think\Exception;
use think\Request;
use think\Validate;
use app\lib\exception\ParameterException;

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

    /**
     * 验证值是不是正整数
     * @param $value
     * @param string $rule
     * @param array $data
     * @param string $field
     * @return bool
     * @author ldz
     * @time 2019-8-19 19:40:52
     */
    protected function isPositiveInteger($value, $rule = '',$data = [], $field = ''){
        if(is_numeric($value) && is_int($value + 0) && ($value + 0 ) > 0){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 验证值是否为空
     * @param $value
     * @param string $rule
     * @param array $data
     * @param string $field
     * @return bool
     * @author ldz
     * @time 2019/10/14 9:20
     */
    protected function isNotEmpty($value, $rule = '',$data = [], $field = ''){
        if(empty($value)){
            return false;
        }else{
            return true;
        }
    }

}
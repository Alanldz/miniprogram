<?php
/**
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/9/10
 * Time: 20:16
 */

namespace app\api\Controller\v1;

use app\api\model\Product as ProduceModel;
use app\api\validate\CountValidate;
use app\lib\exception\ProductException;

class Product
{

    public function getRecent($count = 15){
        (new CountValidate())->goCheck();
        $products = ProduceModel::getMostRecent($count);
        if($products->isEmpty()){
            throw new  ProductException();
        }
        $products = $products->hidden(['summary']);
        return json($products);
    }

}
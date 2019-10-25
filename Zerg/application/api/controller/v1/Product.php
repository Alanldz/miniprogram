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
use app\api\validate\IDMustBePostLiveInt;
use app\lib\exception\ProductException;

class Product
{

    /**
     * @param int $count
     * @return \think\response\Json
     * @throws ProductException
     * @throws \think\Exception
     * @author ldz
     * @time 2019/10/12 17:42
     */
    public function getRecent($count = 15)
    {
        (new CountValidate())->goCheck();
        $products = ProduceModel::getMostRecent($count);
        if ($products->isEmpty()) {
            throw new  ProductException();
        }
        $products = $products->hidden(['summary']);
        return json($products);
    }

    /**
     * 按分类ID获取商品信息
     * @param int $id 分类ID
     * @return \think\response\Json
     * @throws ProductException
     * @throws \think\Exception
     * @author ldz
     * @time 2019/10/12 17:53
     */
    public function getAllInCategory($id)
    {
        (new IDMustBePostLiveInt())->goCheck();
        $products = ProduceModel::getProductByCategory($id);
        if ($products->isEmpty()) {
            throw new ProductException();
        }
        $products = $products->hidden(['summary']);
        return json($products);
    }

    /**
     * 获取商品信息
     * @param $id
     * @return \think\response\Json
     * @throws ProductException
     * @throws \think\Exception
     * @author ldz
     * @time 2019/10/17 20:23
     */
    public function getOne($id)
    {
        $dd = [
           'products'=> [
               'product_id' => 1,
               'count' => 2
           ],
            [
                'product_id' => 2,
                'count' => 3
            ],
        ];

        return json($dd);
        (new IDMustBePostLiveInt())->goCheck();
        $product = ProduceModel::getProductDetail($id);
        if (!$product) {
            throw new ProductException();
        }
        return json($product);
    }

}
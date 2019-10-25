<?php
/**
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/8/13
 * Time: 21:25
 */

namespace app\api\model;

class Product extends BaseModel
{
    //隐藏字段
    protected $hidden = ['update_time', 'create_time', 'delete_time', 'category_id', 'from', 'pivot'];

    public function getMainImgUrlAttr($value, $data)
    {
        return $this->prefixImgUrl($value, $data);
    }

    /**
     * 关联商品详情
     */
    public function properties()
    {
        return $this->hasMany('ProductProperty', 'product_id', 'id');
    }

    /**
     * 关联图片
     */
    public function imgs()
    {
        return $this->hasMany('ProductImage', 'product_id', 'id');
    }

    public static function getMostRecent($count)
    {
        return self::limit($count)->order('create_time desc')->select();
    }

    /**
     * 按分类ID获取商品信息
     */
    public static function getProductByCategory($categoryID)
    {
        return self::where('category_id', '=', $categoryID)->select();
    }

    public static function getProductDetail($id)
    {
        return self::where('id', '=', $id)
            ->with([
                'imgs' => function ($query) {
                    $query->order('order', 'asc')->with(['imgUrl']);
                }
            ])
            ->with(['properties'])
            ->select();
    }


}
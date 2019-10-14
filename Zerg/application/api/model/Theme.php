<?php
/**
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/8/13
 * Time: 21:26
 */

namespace app\api\model;

class Theme extends BaseModel
{
    //隐藏不显示字段
    protected $hidden = ['delete_time', 'update_time', 'topic_img_id', 'head_img_id'];

    /**
     * 关联主题图片
     * @return \think\model\relation\BelongsTo
     * @author ldz
     * @time 2019-8-21 19:36:40
     */
    public function topicImg()
    {
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }

    /**
     * 关联专题列表页图片
     * @return \think\model\relation\BelongsTo
     * @author ldz
     * @time 2019-8-21 19:37:01
     */
    public function headImg()
    {
        return $this->belongsTo('Image', 'head_img_id', 'id');
    }

    /**
     * 关联商品表
     * @return \think\model\relation\belongsToMany
     * @author ldz
     * @time 2019-9-10 19:28:34
     */
    public function products()
    {
        return $this->belongsToMany('product', 'theme_product', 'product_id', 'theme_id');
    }

    /**
     * 获取主题信息
     * @param $id
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author ldz
     * @time 2019-9-10 19:57:35
     */
    public static function getThemeWithProducts($id)
    {
        return self::with('products,topicImg,headImg')->find($id);
    }


}
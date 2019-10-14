<?php
/**
 * Created by PhpStorm.
 * User: ldz
 * Date: 2019/9/11
 * Time: 19:37
 */

namespace app\api\Controller\v1;

use app\api\model\Category as CategoryModel;
use app\lib\exception\CategoryException;


class Category
{

    /**
     * 获取所有分类数据
     * @return \think\response\Json
     * @throws CategoryException
     * @throws \think\exception\DbException
     * @author ldz
     * @time 2019/10/12 17:34
     */
    public function getAllCategories(){
        $category = CategoryModel::all(['id'=>8],'img');
        if($category->isEmpty()){
            throw new CategoryException();
        }
        return json($category);
    }

}
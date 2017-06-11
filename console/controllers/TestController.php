<?php

namespace console\controllers;

use common\modules\store\models\product\ProductBuilding as Product;
use frontend\models\Test;
use yii\console\Controller;
use Yii;


class TestController extends Controller
{
    public function actionIndex()
    {
        $query = Product::find();
        $modelBase = new Test();
        foreach ($query->each() as $product) {
            $model =  clone $modelBase;

            $model->source_id = $product->source_id;
            $model->group = $product->group;
            $model->model = $product->model;
            $model->user_id = $product->user_id;
            $model->sku = $product->sku;
            $model->price = $product->price;
            $model->title = $product->title;
            $model->index = $product->index;
            $model->entity_id = rand(10,10000);
            $model->save();

            echo $product->id."\n";
        }
    }
}

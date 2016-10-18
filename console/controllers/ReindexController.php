<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\helpers\ArrayHelper;
use common\modules\import\components\Reindex;
use common\modules\product\models\ProductRepository;
use common\modules\import\indexers\ImageFromArchive;
use common\modules\import\indexers\ImageFromUrl;

class ReindexController extends Controller 
{
    public function actionIndex()
    {
        
        $models = array_unique(ArrayHelper::getValue(Yii::$app->params,'catalog.models'));
       
        foreach($models as $item){
           
            $model = new $item();
            $reindex = Yii::$container->get(Reindex::class); 
            $reindex->addIndexer(Yii::$container->get(ImageFromUrl::class, [$model]));
            
            $reindex->model = new ProductRepository($model);
            $reindex->run();  
        }
    }
}

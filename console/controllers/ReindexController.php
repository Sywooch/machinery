<?php

namespace console\controllers;

use common\modules\import\models\Insert;
use Yii;
use yii\console\Controller;
use common\modules\import\models\Sources;
use common\modules\import\models\Validate;
use common\modules\import\Import;
use common\modules\import\helpers\ImportHelper;
use common\modules\import\models\TemporaryTerms;
use yii\helpers\Console;

use yii\helpers\ArrayHelper;
use common\modules\import\components\Reindex;
use backend\models\ProductSearch;
use common\modules\import\indexers\ImageFromArchive;

class ReindexController extends Controller 
{
    public function actionIndex()
    {
        
        $models = array_unique(ArrayHelper::getValue(Yii::$app->params,'catalog.models'));
       
        
        foreach($models as $item){
            $model = new $item();
            $reindex = Yii::$container->get(Reindex::class); 
            $reindex->addIndexer(Yii::$container->get(ImageFromArchive::class, [$model]));
            $reindex->model = new ProductSearch($model);
            $reindex->run();    
        }
    }
}

<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\modules\import\models\Sources;
use common\modules\import\models\Validate;
use common\modules\import\components\Import;
use common\modules\import\models\TemporaryTerms;
use yii\helpers\Console;
use common\helpers\ModelHelper;
use common\modules\product\helpers\ProductHelper;

class ImporterController extends Controller 
{

    public function actionIndex()
    {
        $sources = Sources::find()->where(['status' => Sources::STATUS_ACTIVE])->andWhere(['<', 'tires' , Sources::TIRES])->all();
        $import = Yii::$container->get(Import::class,[$this]); 
        $import->sources = Sources::find()->where(['status' => Sources::STATUS_ACTIVE])->andWhere(['<', 'tires' , Sources::TIRES])->all();
        $import->run();
    }
}

<?php

namespace common\modules\search\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{

    /**
     * @param string $s
     * @return string
     */
    public function actionIndex(string $s)
    {
       return $this->render('results',[
           'dataProvider' => $this->module->getSearch()->search($s)
       ]);
    }

}

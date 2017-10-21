<?php

namespace common\modules\search\controllers;

use yii\console\Controller;

class IndexController extends Controller
{

    /**
     *
     */
    public function actionIndex()
    {
       $this->module->getSearch()->getIndex()->run();
    }

}

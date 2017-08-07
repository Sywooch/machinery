<?php
/**
 * Created by PhpStorm.
 * User: slava
 * Date: 18.07.2017
 * Time: 11:15
 */

namespace frontend\controllers;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\helpers\ModelHelper;


class CatalogController extends Controller
{
    public function actionIndex(){
        return $this->render('index');
    }
}
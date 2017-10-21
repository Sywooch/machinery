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
use common\models\Advert;


class CatalogController extends Controller
{
    public function actionIndex($slug=''){
        $model = Advert::find()->all();
        return $this->render('index', ['model'=>$model]);
    }
    public function actionSearch(){
        return $this->render('index');
    }
}
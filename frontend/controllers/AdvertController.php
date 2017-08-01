<?php


namespace frontend\controllers;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\helpers\ModelHelper;


class AdvertController extends Controller
{
    public function actionCreate(){
        return $this->render('create');
    }

    public function actionView(){
        return $this->render('view');
    }
}
<?php

namespace frontend\controllers;

use frontend\components\MathCaptchaAction;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\helpers\ModelHelper;

class MycabController extends Controller 
{

	public $layout = 'account';
	public function actionProfile(){

		return $this->render('profile');
	}

}
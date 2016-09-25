<?php
namespace frontend\controllers;

use Yii;
use backend\models\AdsActions;
use yii\web\Controller;
/**
 * Site controller
 */
class ActionsController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index',[
            'models' => AdsActions::find()->with('alias')->all(),
        ]);
    }
    
    public function actionDefault($id)
    {
        return $this->render('view',[
            'model' => AdsActions::findOne($id),
        ]);
    }
}

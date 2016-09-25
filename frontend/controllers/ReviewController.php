<?php
namespace frontend\controllers;

use Yii;
use backend\models\Review;
use yii\web\Controller;
/**
 * Site controller
 */
class ReviewController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index',[
            'models' => Review::find()->with('alias')->all(),
        ]);
    }
    
    public function actionDefault($id)
    {
        return $this->render('view',[
            'model' => Review::findOne($id),
        ]);
    }
}

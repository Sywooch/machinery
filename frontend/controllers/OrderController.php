<?php


namespace frontend\controllers;

use common\models\OrderPackage;
use common\models\OrderPackageRepository;
use common\models\TarifOptions;
use Yii;
use yii\web\NotFoundHttpException;
use common\modules\language\models\LanguageRepository;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\web\Controller;
use dektrium\user\Finder;

class OrderController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['create', 'options'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    public function actionCreate()
    {

    }
    public function actionOptions()
    {
        if(Yii::$app->request->isAjax){
            $user_id = Yii::$app->user->id;
            $options = Yii::$app->request->post('opt') ?? null;
            $price   = 0;
            if($options){
                $price = TarifOptions::find()->where(['in', 'id', $options])->sum('price');
            }
            $order = OrderPackage::find()->where(['user_id'=>$user_id, 'package_id'=>null, 'status'=>0])->one();
            if(!$order){
                $order = new OrderPackage();
            }

            $order->user_id     = $user_id;
            $order->status      = 0;
            $order->package_id  = null;
            $order->options     = json_encode($options);
            $order->create_at   = time();
            $order->cost        = $price;
            if($order->save())
                dd($order);
        }

    }

}
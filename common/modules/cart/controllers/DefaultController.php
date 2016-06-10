<?php

namespace common\modules\cart\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use common\helpers\ModelHelper;

/**
 * ItemsController implements the CRUD actions for TaxonomyItems model.
 */
class DefaultController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all TaxonomyItems models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', [
                    'order' => Yii::$app->cart->getOrder()
        ]);
    }

    public function actionAdd($entityId, $entityName){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(($model = ModelHelper::getModelByName($entityName)) === false){
            throw new BadRequestHttpException();
        }
        $product = $model::findOne($entityId);
        if(!$product){
            throw new BadRequestHttpException();
        }
        Yii::$app->cart->addItem($product);
        $order = Yii::$app->cart->getOrder();
        return [
                'success' => 'true',
                'order' => Yii::$app->cart->getOrder(),
                'product' => $product,
                'formaters' => [
                    'items' => Yii::t('app', '{n, plural, =0{Корзина} one{# товар} few{# товара} many{# товаров} other{# товаров}}', array(
                        'n' => $order->count 
                    )),
                    'total' => Yii::$app->formatter->asCurrency($order->price)
                ]
        ];
    }
    
    public function actionCount($id, $count){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(($order = Yii::$app->cart->countItem($id, $count)) === null){
            throw new BadRequestHttpException();
        }
        $product = $order->getItem($id);
        return [
                'success' => 'true',
                'order' => $order,
                'item' => $product,
                'formaters' => [
                    'items' => Yii::t('app', '{n, plural, =0{Корзина} one{# товар} few{# товара} many{# товаров} other{# товаров}}', array(
                        'n' => $order->count 
                    )),
                    'total' => Yii::$app->formatter->asCurrency($order->price),
                    'itemTotal' => Yii::$app->formatter->asCurrency($product->price * $product->count)
                ]
        ];
    }
    
    public function actionRemove($id){
        Yii::$app->cart->removeItem($id);
        return $this->redirect(['/cart']);
    }
}

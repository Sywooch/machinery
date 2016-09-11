<?php

namespace frontend\modules\cart\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use frontend\modules\catalog\helpers\CatalogHelper;

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
        if(Yii::$app->request->isPost){
            return $this->redirect(['/orders']);
        }
        
        return $this->render('index', [
                    'cart' => Yii::$app->cart            
        ]);
    }
    
    public function actionAdd($entityId, $entityName){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(($model = CatalogHelper::getModelByName($entityName)) === false){
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
        
        $price = Yii::$app->cart->isPromoItem($product) ? $product->origin->promoPrice : $product->price;
        
        return [
                'success' => 'true',
                'order' => $order,
                'item' => $product,
                'formaters' => [
                    'items' => Yii::t('app', '{n, plural, =0{Корзина} one{# товар} few{# товара} many{# товаров} other{# товаров}}', array(
                        'n' => $order->count 
                    )),
                    'total' => Yii::$app->formatter->asCurrency($order->price),
                    'itemTotal' => Yii::$app->formatter->asCurrency($price * $product->count),
                    'itemRealTotal' => Yii::$app->formatter->asCurrency($product->price * $product->count)
                ]
        ];
    }
    
    public function actionRemove(array $id){
        foreach($id as $item){
          Yii::$app->cart->removeItem($item); 
        }
        return $this->redirect(['/cart']);
    }
}

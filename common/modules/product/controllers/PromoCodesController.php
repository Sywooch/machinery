<?php

namespace common\modules\product\controllers;

use Yii;
use common\modules\product\models\PromoProducts;
use common\modules\product\models\PromoCodes;
use common\modules\product\models\PromoCodesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\ModelHelper;
use yii\helpers\ArrayHelper;

/**
 * PromoCodesController implements the CRUD actions for PromoCodes model.
 */
class PromoCodesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'delete', 'find-ajax', 'add-ajax'],
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['use-ajax']
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    
    public function actionAddAjax($code, $id, $model){
        
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $code = PromoCodes::find()->where([
            'code' => $code
        ])->one();
        
        if(!$code){
            return false;
        }
         
        $modelClass = ModelHelper::getModelClass($model);
        
        $productModel = $modelClass::findOne($id);
    
        if(!$productModel){
            return false;
        }        
     
        if($productModel->promoItem){
           return false; 
        }
        
        $promoProductModel = new PromoProducts();
        $promoProductModel->code_id = $code->id;
        $promoProductModel->entity_id = $id;
        $promoProductModel->model = $model;
        $promoProductModel->save();

        return ['status' => 'success', 'message' => ''];
    }
    
    public function actionUseAjax($code){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $code = PromoCodes::find()
        ->where([
            'code' => $code
        ])->one();
        
        if(!$code){
            return ['status' => 'error','message' => 'Ошибочный код'];
        }
        
        $order = Yii::$app->cart->getOrder();
       
        if(in_array($code->id, ArrayHelper::getColumn($order->promo, 'entity_id'))){
           return ['status' => 'error','message' => 'Код уже использован']; 
        }

        $codeIds = [];
        foreach($order->items as $item ){
                if(isset($item->origin->promoCode)){
                    $codeIds[$item->origin->promoCode->id] = $item->origin->promoCode->id;
                }
        }
        
        if(!in_array($code->id, $codeIds)){
            return ['status' => 'error','message' => 'Код не подходит к данным продуктам'];
        }
        
        Yii::$app->cart->addItem($code);
        
        return ['status' => 'success','message' => ''];

    }


    public function actionFindAjax($term){
        \Yii::$app->response->format = 'json';
        return  PromoCodes::find()
        ->select(['code as value', 'code as label'])
        ->asArray()
        ->where([
            'like', 'code', $term
        ])->all();
       
    }

    /**
     * Lists all PromoCodes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PromoCodesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PromoCodes model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PromoCodes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PromoCodes();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $length = 12;
            do {
                $model->code = strtoupper (substr(str_shuffle(str_repeat($x='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length));
                $finded = PromoCodes::find()->where(['code' => $model->code])->one();  
            }while($finded);
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PromoCodes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PromoCodes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PromoCodes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PromoCodes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

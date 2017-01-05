<?php
namespace common\modules\store\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use common\modules\store\helpers\ProductHelper;
use common\modules\store\models\product\ProductInterests;
use common\modules\store\models\promo\PromoCodes;
use common\modules\store\Finder;


/**
 * Site controller
 */
class ProductController extends Controller
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
                        'actions' => ['list', 'update', 'view', 'create', 'delete'],
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'otzyvy']
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
    
    
    
    /**
     * Lists all ProductDefault models.
     * @return mixed 
     */
    public function actionList($model)
    {
        $model = ProductHelper::getModel($model);
        $finder = Yii::$container->get(Finder::class, [$model]);
        $dataProvider = $finder->search(Yii::$app->request->queryParams);
        return $this->render('list', [
            'model' => $model,
            'searchModel' => $finder->produtSearch,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Displays a single ProductDefault model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id, $model)
    {
        $promoCodes = new PromoCodes();
        return $this->render('view', [
            'model' => $this->findModel($id, $model),
            'promoCodes' => $promoCodes
        ]);
    }
    
    /**
     * Creates a new ProductDefault model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($model)
    {

        $model = ProductHelper::getModel($model);
        $model->loadDefaultValues();

        if ($model->load(Yii::$app->request->post())) {
            \common\modules\file\Uploader::getInstances($model);
            if($model->save()){
                 return $this->redirect(['view', 'id' => $model->id, 'model' => \yii\helpers\StringHelper::basename(get_class($model))]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProductDefault model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $model)
    {
        $model = $this->findModel($id, $model); 

        if ($model->load(Yii::$app->request->post())) {
            \common\modules\file\Uploader::getInstances($model);
            if($model->save()){
                 return $this->redirect(['view', 'id' => $model->id, 'model' => \yii\helpers\StringHelper::basename(get_class($model))]);
            }
        }
        
        return $this->render('update', [
            'model' => $model,
        ]);
        
    }

    /**
     * Deletes an existing ProductDefault model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id, $model)
    {
        $this->findModel($id, $model)->delete();

        return $this->redirect(['index', 'model' => $model]);
    }

    /**
     *
     * @return mixed
     */
    public function actionIndex($id, $model)
    {   
        $finder = Yii::$container->get(Finder::class, [ProductHelper::getModel($model)]);
        $product = $finder->getProductById($id);

        if(empty($product)){
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        ProductInterests::push($product);
        return $this->render('index',[
            'product' => $product,
        ]);
        
    }
    
    /**
     *
     * @return mixed
     */
    public function actionOtzyvy($id, $model, $tab)
    {   
        $finder = Yii::$container->get(Finder::class, [ProductHelper::getModel($model)]);
        $products = $finder->getProductsByGroup($id);

        if(empty($products)){
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }
        return $this->render('index',[
            'products' => $products,
            'product' => current($products),
            'tab' => $tab
        ]);   
    }

    protected function findModel($id, $model)
    {
        $model = ProductHelper::getClass($model);
        if (($model = $model::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

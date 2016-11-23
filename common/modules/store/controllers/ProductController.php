<?php
namespace common\modules\store\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use common\modules\product\models\ProductRepository;
use common\helpers\ModelHelper;
use yii\helpers\ArrayHelper;
use common\modules\store\models\ProductInterests;
use common\modules\store\models\ProductDefault;
use common\modules\store\models\ComparesSearch;
use common\modules\store\models\ProductSearch;
use common\modules\orders\models\PromoCodes;

/**
 * Site controller
 */
class ProductController extends Controller
{
    
    /**
     * @inheritdoc
     */
    public function actions()
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
                ],
            ],
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    
    /**
     * Lists all ProductDefault models.
     * @return mixed 
     */
    public function actionList()
    {
        $searchModel = new ProductSearch(new ProductDefault());
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Displays a single ProductDefault model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $promoCodes = new PromoCodes();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'promoCodes' => $promoCodes
        ]);
    }
    
    /**
     * Creates a new ProductDefault model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new ProductDefault();
        $model->loadDefaultValues();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
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
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
         //   print_r($model->getErrors()); exit('s');
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ProductDefault model.
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
     * Finds the ProductDefault model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductDefault the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductDefault::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     *
     * @return mixed
     */
    public function actionIndex($id, $model)
    {   
        $product = ProductDefault::findOne($id);
        
        if(empty($product)){
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }
        
        ProductInterests::push($product);
        
        $compareSearch = Yii::$container->get(ComparesSearch::class);

        $compares = ArrayHelper::map($compareSearch,'entity_id','entity_id','model');
        return $this->render('index',[
            'product' => $product,
            'compareIds' => isset($compares[$model]) ? $compares[$model] : [], 
        ]);
        
    }
    
    /**
     *
     * @return mixed
     */
    public function actionOtzyvy($id, $model, $tab)
    {   
        $searchModel = new ProductRepository(ModelHelper::getModelByName($model));
        $ids = $searchModel->getProductsByGroup($id);
        $products = $searchModel->getProductsByIds($ids);

        if(empty($products)){
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }
        $compares = ArrayHelper::map(Compares::getItems(),'entity_id','entity_id','model');
        return $this->render('index',[
            'products' => $products,
            'product' => reset($products),
            'compareIds' => isset($compares[$model]) ? $compares[$model] : [], 
            'tab' => $tab
        ]);
        
    }

    
}

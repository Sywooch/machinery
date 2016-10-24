<?php

namespace common\modules\taxonomy\controllers;

use Yii;
use common\modules\taxonomy\models\TaxonomyItems;
use common\modules\taxonomy\models\TaxonomyItemsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\modules\taxonomy\helpers\TaxonomyHelper;

/**
 * ItemsController implements the CRUD actions for TaxonomyItems model.
 */
class ItemsController extends Controller
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
                        'actions' => ['index', 'update', 'view', 'create', 'delete', 'hierarchy','terms-ajax'],
                        'roles' => ['admin'],
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
     * Lists all TaxonomyItems models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaxonomyItemsSearch();
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TaxonomyItems model.
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
     * Creates a new TaxonomyItems model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TaxonomyItems();
        $model->load(Yii::$app->request->queryParams);
        $parentTerm = new TaxonomyItems();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['create', 'TaxonomyItems' => ['vid' => $model->vid]]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'parentTerm' => $parentTerm
            ]);
        }
    }

    /**
     * Updates an existing TaxonomyItems model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if($model->pid){
            $parentTerm = TaxonomyItems::findOne($model->pid);
        }else{
            $parentTerm = new TaxonomyItems();
        }
       
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'parentTerm' => $parentTerm
            ]);
        }
    }

    /**
     * Deletes an existing TaxonomyItems model.
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
     * Finds the TaxonomyItems model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TaxonomyItems the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TaxonomyItems::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
     * 
     * @return mixed
     */
    public function actionHierarchy() {

        $taxonomyItemsSearch = new TaxonomyItemsSearch();

        if ($data = Yii::$app->request->post()) {
            $orders = TaxonomyHelper::nes2Flat($data['data'],$data['pid']);
            $taxonomyItemsSearch->setOrder($data['vid'], $orders);
            
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['result' => 'success'];
        }

        if (($taxonomyItemsSearch->load(Yii::$app->request->get()) && $taxonomyItemsSearch->validate())) {
            $terms = $taxonomyItemsSearch->getTaxonomyItemsByVid($taxonomyItemsSearch->vid);
            $tree = TaxonomyHelper::tree($terms, $taxonomyItemsSearch->pid);
            $parentTerm = $taxonomyItemsSearch::findOne($taxonomyItemsSearch->pid);

            return $this->render('hierarchy', [
                        'model' => $taxonomyItemsSearch,
                        'tree' => $tree,
                        'vocabularyId' => $taxonomyItemsSearch->vid,
                        'parentTerm' => $parentTerm, 
                         
            ]);
        }
         
        return $this->render('hierarchy', [
                    'model' => $taxonomyItemsSearch,
                    'tree' => [],
        ]);
    }
    
    public function actionTermsAjax($vocabularyId = null, $name, $exeptId = null){

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $taxonomyItemsSearch = new TaxonomyItemsSearch();
        $terms = $taxonomyItemsSearch->getItemsByName($name, $vocabularyId);
        
        if(empty($terms)){
            return ['results' => [] ];
        }
        
        if($exeptId && key_exists($exeptId, $terms)){
            unset($terms[$exeptId]);
        }
        
        $terms = array_values($terms);
        
        return ['results' => $terms ];

    }
    
    
}

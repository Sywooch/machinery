<?php

namespace common\modules\store\controllers;

use common\modules\file\Uploader;
use common\modules\store\models\product\Product;
use common\modules\store\models\product\ProductBase;
use common\modules\store\models\product\ProductRepository;
use common\modules\store\models\product\ProductSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
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
                        'actions' => ['update', 'view', 'create', 'delete', 'find-ajax'],
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
     * Lists all ProductBase models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string
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
     * Creates a new ProductBase model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Product();
        $model->loadDefaultValues();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            Uploader::getInstances($model);
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            // print_r($model->getErrors()); exit();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            Uploader::getInstances($model);
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                // print_r($model->getErrors()); exit();
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);

    }

    /**
     * @param $term
     * @return array|\yii\db\ActiveRecord[]
     */
    public function actionFindAjax($term)
    {
        \Yii::$app->response->format = 'json';

        $repository = new ProductRepository();

        return ArrayHelper::toArray($repository->findByName($term, 30), [
            Product::class => [
                'id' => 'id',
                'value' => 'title',
                'label' => 'title'
            ]
        ]);

    }

    /**
     * Deletes an existing ProductBase model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id, $model)
    {
        $this->findModel($id, $model)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

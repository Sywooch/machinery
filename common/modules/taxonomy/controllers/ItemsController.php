<?php

namespace common\modules\taxonomy\controllers;

use yii;
use common\modules\taxonomy\models\TaxonomyItems;
use common\modules\taxonomy\models\TaxonomyItemsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\modules\taxonomy\helpers\TaxonomyHelper;
use yii\web\Response;
use yii\base\Module;
use common\modules\taxonomy\Taxonomy;
use common\modules\taxonomy\models\TaxonomyItemsHierarchy;
use common\modules\file\Uploader;

/**
 * ItemsController implements the CRUD actions for TaxonomyItems model.
 */
class ItemsController extends Controller
{

    private $_taxonomy;

    public function __construct($id, Module $module, Taxonomy $taxonomy, array $config = [])
    {
        $this->_taxonomy = $taxonomy;
        parent::__construct($id, $module, $config);
    }

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
                        'actions' => ['index', 'update', 'view', 'create', 'delete', 'hierarchy', 'order', 'terms-ajax'],
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'order' => ['POST'],
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['create', 'TaxonomyItems' => ['vid' => $model->vid]]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'parentTerm' => new TaxonomyItems()
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
        if ($model->pid) {
            $parentTerm = TaxonomyItems::findOne($model->pid);
        } else {
            $parentTerm = new TaxonomyItems();
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'parentTerm' => $parentTerm
        ]);
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
     * @return array
     */
    public function actionOrder()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        if (Yii::$app->request->isPost) {
            $this->_taxonomy->orderVocabulary(Yii::$app->request->post('vid'), Yii::$app->request->post('data'), Yii::$app->request->post('pid'));
            return ['result' => 'success'];
        }

        return [];
    }

    /**
     * @return string
     * @throws yii\base\InvalidConfigException
     */
    public function actionHierarchy()
    {
        $model = Yii::$container->get(TaxonomyItemsHierarchy::class);
        if ($model->load(Yii::$app->request->get()) && $model->validate()) {
            return $this->render('hierarchy', [
                'model' => $model
            ]);
        }

        return '';
    }

    /**
     * @param string $name
     * @param null $vocabularyId
     * @param null $excludedId
     * @return array
     */
    public function actionTermsAjax(string $name, $vocabularyId = null, $excludedId = null)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $terms = $this->_taxonomy->getItemsRepository()->findByName($name, $vocabularyId);

        return ['results' => TaxonomyHelper::toArray($terms, [$excludedId])];
    }


}

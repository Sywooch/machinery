<?php

namespace backend\controllers;

use common\models\AdsBannersRepository;
use common\models\AdsRegionsRepository;
use common\modules\taxonomy\models\TaxonomyItemsRepository;
use Yii;
use common\models\AdsBanners;
use common\models\AdsBannersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * AdsBannersController implements the CRUD actions for AdsBanners model.
 */
class AdsBannersController extends Controller
{
    const CATALOG_ID = 1;

    /**
     * @var AdsRegionsRepository
     */
    private $_regionsRepository;

    /**
     * @var TaxonomyItemsRepository
     */
    private $_itemsRepository;

    public function __construct($id, $module, AdsRegionsRepository $regionsRepository, TaxonomyItemsRepository $itemsRepository, array $config = [])
    {
        $this->_itemsRepository = $itemsRepository;
        $this->_regionsRepository = $regionsRepository;
        parent::__construct($id, $module, $config);
    }

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
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
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
     * Lists all AdsBanners models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdsBannersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AdsBanners model.
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
     * Creates a new AdsBanners model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AdsBanners();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'regions' => $this->_regionsRepository->getRegions(),
                'catalog' => $this->_itemsRepository->getVocabularyTerms(self::CATALOG_ID)
            ]);
        }
    }

    /**
     * Updates an existing AdsBanners model.
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
            return $this->render('update', [
                'model' => $model,
                'regions' => $this->_regionsRepository->getRegions(),
                'catalog' => $this->_itemsRepository->getVocabularyTerms(self::CATALOG_ID)
            ]);
        }
    }

    /**
     * Deletes an existing AdsBanners model.
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
     * Finds the AdsBanners model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AdsBanners the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AdsBanners::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

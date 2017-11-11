<?php

namespace backend\controllers;

use common\modules\language\models\Language;
use Yii;
use common\models\Advert;
use common\models\AdvertSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\modules\language\models\LanguageRepository;
use yii\base\Module;
use common\modules\taxonomy\models\TaxonomyItemsRepository;

/**
 * AdvertController implements the CRUD actions for Advert model.
 */
class AdvertController extends Controller
{
    /**
     * @var LanguageRepository
     */
    public $languageRepository;
    public $itemsRepository;


    public function __construct($id, Module $module, LanguageRepository $languageRepository, TaxonomyItemsRepository $itemsRepository,  array $config = [])
    {
        $this->languageRepository = $languageRepository;
        $this->itemsRepository    = $itemsRepository;
        parent::__construct($id, $module, $config);
    }

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
     * Lists all Advert models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdvertSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Advert model.
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
     * Creates a new Advert model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Advert();


        if ($model->load(Yii::$app->request->post())) {
            dd($model, 1);
            if($model->save())
                return $this->redirect(['update', 'id' => $model->id]);
        }

            return $this->render('create', [
                'model' => $model,
                'languages' => $this->languageRepository->loadAllActive(),
                'categories' => $this->itemsRepository->getVocabularyTerms(Advert::VCL_CATEGORIES),
                'manufacturer' => $this->itemsRepository->getVocabularyTerms(Advert::VCL_MANUFACTURES),
                'colors' => $this->itemsRepository->getVocabularyTerms(Advert::VCL_COLOR),
            ]);

    }

    /**
     * Updates an existing Advert model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'languages' => $this->languageRepository->loadAllActive(),
                'categories' => $this->itemsRepository->getVocabularyTerms(Advert::VCL_CATEGORIES),
                'manufacturer' => $this->itemsRepository->getVocabularyTerms(Advert::VCL_MANUFACTURES),
                'colors' => $this->itemsRepository->getVocabularyTerms(Advert::VCL_COLOR),
            ]);
        }
    }

    /**
     * Deletes an existing Advert model.
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
     * Finds the Advert model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Advert the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Advert::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

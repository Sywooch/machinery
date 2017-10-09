<?php

namespace backend\controllers;

use common\models\PackageOption;
use Yii;
use common\models\TarifPackages;
use common\models\TarifPackagesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\modules\language\models\LanguageRepository;
use yii\base\Module;
use common\models\OoptionsRepository;

/**
 * PackagesController implements the CRUD actions for TarifPackages model.
 */
class PackagesController extends Controller
{
    /**
     * @var LanguageRepository
     */
    public $languageRepository;
    /**
     * @var optionsRepository
     */
    public $optionsRepository;

    public function __construct($id, Module $module, LanguageRepository $languageRepository, OoptionsRepository $optionsRepository, array $config = [])
    {
        $this->languageRepository = $languageRepository;
        $this->optionsRepository  = $optionsRepository;
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
                        'actions' => ['index', 'update', 'view', 'create'],
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
     * Lists all TarifPackages models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TarifPackagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TarifPackages model.
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
     * Creates a new TarifPackages model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TarifPackages();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TarifPackages model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {


            return $this->redirect('index');
        } else {
            return $this->render('update', [
                'model' => $model,
//                'options' => $this->optionsRepository->getOptionsActive(),
            ]);
        }
    }


    /**
     * Deletes an existing TarifPackages model.
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
     * Finds the TarifPackages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TarifPackages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TarifPackages::find()->where(['id' => $id])->with('optionsPack')->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

<?php

namespace backend\controllers;

use common\models\Alias;
use common\modules\taxonomy\models\TaxonomyItemsRepository;
use Yii;
use backend\models\Pages;
use backend\models\PagesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\modules\language\models\LanguageRepository;
use yii\base\Module;

/**
 * PagesController implements the CRUD actions for Pages model.
 */
class PagesController extends Controller
{
    /**
     * @var LanguageRepository
     */
    public $languageRepository;


    public function __construct($id, Module $module, LanguageRepository $languageRepository, array $config = [])
    {
        $this->languageRepository = $languageRepository;
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
     * Lists all Pages models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Pages model.
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
     * Creates a new Pages model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($parent = null, $lang = null)
    {

        $model = new Pages();
        $translates = Pages::find()->where(['parent' => $parent])->all();
        if ($parent) $model->parent = $parent;
        if ($lang) $model->lang = $lang;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $a = Alias::find()->where(['entity_id' => $id, 'model' => 'Pages'])->one();
                if (!count($a)) {
                    $a = new Alias();
                    $a->url = 'pages/view?id=' . $model->id;
                    $a->model = 'Pages';
                    $a->entity_id = $model->id;
                }
                $a->alias = $_POST['Pages']['alias']['alias'];
                $a->save();
                Yii::$app->session->setFlash('success', Yii::t('app', 'The object was successfully saved.'));
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'languages' => $this->languageRepository->loadAllActive(),
            'translates' => $translates,
//                'terms1' => (new TaxonomyItemsRepository())->getVocabularyTerms(1),
//                'terms2' => (new TaxonomyItemsRepository())->getVocabularyTerms(4)
        ]);

    }

    /**
     * Updates an existing Pages model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = Pages::find()->where(['id' => $id])->with('alias')->one();

        $translates = Pages::find()->with('alias')->where(['parent' => $model->parent])->andWhere(['not', ['id' => $id]])->all();

        if ($post = Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $a = Alias::find()->where(['entity_id' => $id, 'model' => 'Pages'])->one();
                if (!count($a)) {
                    $a = new Alias();
                    $a->url = 'pages/view?id=' . $model->id;
                    $a->model = 'Pages';
                    $a->entity_id = $model->id;
                }
                $a->alias = $_POST['Pages']['alias']['alias'];
                $a->save();
                Yii::$app->session->setFlash('success', Yii::t('app', 'The object was successfully saved.'));
                return $this->redirect(['update', 'id' => $model->id]);
            }

        }
        return $this->render('update', [
            'model' => $model,
            'languages' => $this->languageRepository->loadAllActive(),
            'translates' => $translates,
//                'terms1' => (new TaxonomyItemsRepository())->getVocabularyTerms(1),
//                'terms2' => (new TaxonomyItemsRepository())->getVocabularyTerms(4)
        ]);
    }

    /**
     * Deletes an existing Pages model.
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
     * Finds the Pages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pages::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

<?php


namespace frontend\controllers;

use Yii;
use common\helpers\ModelHelper;
use common\models\Advert;
use yii\web\NotFoundHttpException;
use common\modules\language\models\LanguageRepository;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\web\Controller;
use dektrium\user\Finder;
use common\modules\taxonomy\models\TaxonomyItemsRepository;


class AdvertController extends Controller
{
    /**
     * @var LanguageRepository
     */
    public $languageRepository;
    public $itemsRepository;

    /**
     * @var Finder
     */
    private $_profileFinder;

    public function __construct($id, Module $module, LanguageRepository $languageRepository, TaxonomyItemsRepository $itemsRepository, Finder $finder, array $config = [])
    {
        $this->languageRepository = $languageRepository;
        $this->itemsRepository    = $itemsRepository;
        $this->_profileFinder = $finder;
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
                'only' => ['listing'],
                'rules' => [
                    [
                        'actions' => ['listing'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    public function actionCreate()
    {
        $model = new Advert();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'languages' => $this->languageRepository->loadAllActive(),
                'categories' => $this->itemsRepository->getVocabularyTerms($model::VCL_CATEGORIES),
//                'manufacturer' => $this->itemsRepository->getVocabularyTerms($model::VCL_MANUFACTURES),
            ]);
        }
//        return $this->render('create', ['languages' => $this->languageRepository->loadAllActive()]);
    }

    /**
     * Updates an existing Advert model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(!$model = Advert::find()->where(['id'=>$id])->one())
            throw new NotFoundHttpException('The requested page does not exist.');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'languages' => $this->languageRepository->loadAllActive(),
                'categories' => $this->itemsRepository->getVocabularyTerms(Advert::VCL_CATEGORIES),
//                'manufacturer' => $this->itemsRepository->getVocabularyTerms(Advert::VCL_MANUFACTURES),
            ]);
        }
    }

    public function actionView($id)
    {
        if(!$model = Advert::find()->where(['id'=>$id])->one())
            throw new NotFoundHttpException('The requested page does not exist.');
        // Обновляем счетчик просмотров
        $session = Yii::$app->session;
        $viewed = ($session->has('viewed')) ? $session->get('viewed') : [];
        if(!in_array($id, $viewed)){
            $viewed[] = $id;
            $model->updateCounters(['viewed' => 1]);
        }
        $session->set('viewed', $viewed);
        return $this->render('view', [
            'model'=>$model,
        ]);
    }

    public function actionViewvrs()
    {
        return $this->render('view_verstka');
    }


    /**
     * User advertising page
     *
     * @return string
     */
    public function actionListing()
    {
        $this->layout = 'account';
        $id = \Yii::$app->user->getId();
        $profile = $this->_profileFinder->findProfileById($id);
        return $this->render('listing', ['profile' => $profile,]);
    }

}
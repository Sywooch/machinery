<?php


namespace frontend\controllers;

use common\models\AdvertVariant;
use common\models\OrderPackage;
use common\models\OrderPackageRepository;
use common\services\AdvertService;
use Yii;
use common\helpers\ModelHelper;
use common\models\Advert;
use common\models\AdvertSearch;

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
    private $_advertService;

    /**
     * @var Finder
     */
    private $_profileFinder;

    public function __construct($id, Module $module, LanguageRepository $languageRepository, TaxonomyItemsRepository $itemsRepository, Finder $finder, AdvertService $advertService, array $config = [])
    {
        $this->languageRepository = $languageRepository;
        $this->itemsRepository = $itemsRepository;
        $this->_profileFinder = $finder;
        $this->_advertService = $advertService;
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
                'only' => ['listing', 'create', 'update'],
                'rules' => [
                    [
                        'actions' => ['listing', 'create', 'update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    public function actionCreate($parent = null, $lang = null)
    {
        $lang = $lang ? $lang : Yii::$app->language;
        $model = Advert::findOne($parent) ?? new Advert();
        $translate = new AdvertVariant();
        $translates = $this->getTranslates($parent);
        if (!$translate->lang) $translate->lang = $lang;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($this->_advertService->save($model)) {
                if ($translate->load(Yii::$app->request->post()))
                {
                    $translate->advert_id = $model->id;
                    $translate->save();
                    Yii::$app->session->setFlash('success', Yii::t('app', 'The object was successfully saved.'));
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }

        } else {
            return $this->render('create', [
                'model' => $model,
                'translate' => $translate,
                'translates' => $translates,
                'languages' => $this->languageRepository->loadAllActive(),
                'categories' => $this->itemsRepository->getVocabularyTerms($model::VCL_CATEGORIES),
                'manufacturer' => $this->itemsRepository->getVocabularyTerms($model::VCL_MANUFACTURES),
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
    public function actionUpdate($id, $lang = null)
    {
        $lang = $lang ? $lang : Yii::$app->language;
//        echo $lang;
        if (!$model = Advert::find()->where(['id' => $id])->with(['options', 'variant'])->one())
            throw new NotFoundHttpException('The requested page does not exist.');
        $translates = $this->getTranslates($id);
//        dd($translates, 1);
        $translate = $translates[$lang] ?? new AdvertVariant();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($translate->load(Yii::$app->request->post()))
            {
                $translate->advert_id = $model->id;
                $translate->save();
                Yii::$app->session->setFlash('success', Yii::t('app', 'The object was successfully saved.'));
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'translate' => $translate,
                'translates' => $translates,
                'languages' => $this->languageRepository->loadAllActive(),
                'categories' => $this->itemsRepository->getVocabularyTerms(Advert::VCL_CATEGORIES),
                'manufacturer' => $this->itemsRepository->getVocabularyTerms(Advert::VCL_MANUFACTURES),
            ]);
        }
    }


    public function actionView($id)
    {
        if (!$model = Advert::find()->where(['id' => $id])->one())
            throw new NotFoundHttpException('The requested page does not exist.');
        // Обновляем счетчик просмотров
        $session = Yii::$app->session;
        $viewed = ($session->has('viewed')) ? $session->get('viewed') : [];
        if (!in_array($id, $viewed)) {
            $viewed[] = $id;
            $model->updateCounters(['viewed' => 1]);
        }
        $session->set('viewed', $viewed);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionViewvrs()
    {
        return $this->render('view_verstka');
    }

    public function actionOptions()
    {
        if (Yii::$app->request->isAjax) {
            dd(Yii::$app->request->post('opt'));
        }

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
        $searchModel = new AdvertSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->id);

        return $this->render('listing', [
            'profile' => $profile,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param null $parent
     * @return array|AdvertVariant[]
     */
    public function getTranslates($parent = null)
    {
        return AdvertVariant::find()
            ->where(['advert_id' => $parent])
            ->indexBy('lang')
            ->all();
    }

}
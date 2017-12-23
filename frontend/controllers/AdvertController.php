<?php


namespace frontend\controllers;

use boundstate\plupload\PluploadAction;
use common\models\AdvertVariant;
use common\models\OrderPackage;
use common\models\OrderPackageRepository;
use common\models\Viewed;
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

    public $lang;

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
//        $model->title = 'zzzzzzz';
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($this->_advertService->save($model)) {
                if ($post_trs = Yii::$app->request->post('translate')) {
                    foreach ($post_trs as $l => $data) {
                        if ($data['title'] || $data['body']) {
                            $trs_ins = isset($translates[$l]) ? AdvertVariant::findOne($translates[$l]['id']) : new AdvertVariant();

                            $trs_ins->title = $data['title'];
                            $trs_ins->body = $data['body'];
                            $trs_ins->lang = $l;
                            $trs_ins->advert_id = $model->id;
                            $trs_ins->meta_description = $data['meta_description'];
                            if (!$trs_ins->save()) {
                                echo $trs_ins->getErrors();
                            }

                        }
                    }
                }
                Yii::$app->session->setFlash('success', Yii::t('app', 'The object was successfully saved.'));
                return $this->redirect(['view', 'id' => $model->id]);
//                if ($translate->load(Yii::$app->request->post()))
//                {
//                    $translate->advert_id = $model->id;
//                    $translate->save();
//                }
            }

        } else {
//            print_r($model->getErrors());
            return $this->render('create', [
                'model' => $model,
                'translate' => $translate,
                'translates' => $translates,
                'languages' => $this->languageRepository->loadAllActive(),
                'categories' => $this->itemsRepository->getVocabularyTerms($model::VCL_CATEGORIES),
                'manufacturer' => $this->itemsRepository->getVocabularyTerms($model::VCL_MANUFACTURES),
                'colors' => $this->itemsRepository->getVocabularyTerms(Advert::VCL_COLOR),
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
//        if (Yii::$app->request->post())
//            dd(Yii::$app->request->post(), 1);
        $translate = $translates[$lang] ?? new AdvertVariant();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Сохранение переводов
            if ($post_trs = Yii::$app->request->post('translate')) {
                foreach ($post_trs as $l => $data) {
                    if ($data['title'] || $data['body']) {
                        $trs_ins = isset($translates[$l]) ? AdvertVariant::findOne($translates[$l]['id']) : new AdvertVariant();

                        $trs_ins->title = $data['title'];
                        $trs_ins->body = $data['body'];
                        $trs_ins->lang = $l;
                        $trs_ins->advert_id = $id;
                        $trs_ins->meta_description = $data['meta_description'];
                        if (!$trs_ins->save()) {
                            echo $trs_ins->getErrors();
                        }
                    }
                }
            }
            Yii::$app->session->setFlash('success', Yii::t('app', 'The object was successfully saved.'));
            return $this->redirect(['view', 'id' => $model->id]);

        } else {
        }
        return $this->render('update', [
            'model' => $model,
            'translate' => $translate,
            'translates' => $translates,
            'languages' => $this->languageRepository->loadAllActive(),
            'categories' => $this->itemsRepository->getVocabularyTerms(Advert::VCL_CATEGORIES),
            'manufacturer' => $this->itemsRepository->getVocabularyTerms(Advert::VCL_MANUFACTURES),
            'colors' => $this->itemsRepository->getVocabularyTerms(Advert::VCL_COLOR),
        ]);
    }


    public function actionView($id)
    {
        if (!$model = Advert::find()->with(['variant'])->where(['id' => $id])->one())
            throw new NotFoundHttpException('The requested page does not exist.');
        // Обновляем счетчик просмотров
        $session = Yii::$app->session;
        if (!$model->isAuthor($model)) {
            $model->viewedUpdate($id);
        }

        $model->translate = $model->variant[Yii::$app->language] ? $model->variant[Yii::$app->language] : $model->variant[$model->lang];

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
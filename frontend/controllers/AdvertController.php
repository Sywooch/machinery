<?php


namespace frontend\controllers;

use common\helpers\ModelHelper;
use common\modules\language\models\LanguageRepository;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\web\Controller;
use dektrium\user\Finder;


class AdvertController extends Controller
{
    /**
     * @var LanguageRepository
     */
    public $languageRepository;

    /**
     * @var Finder
     */
    private $_profileFinder;

    public function __construct($id, Module $module, LanguageRepository $languageRepository, Finder $finder, array $config = [])
    {
        $this->languageRepository = $languageRepository;
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

        return $this->render('create', ['languages' => $this->languageRepository->loadAllActive()]);
    }

    public function actionView()
    {
        return $this->render('view');
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
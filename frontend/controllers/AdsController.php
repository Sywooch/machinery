<?php


namespace frontend\controllers;

use common\helpers\ModelHelper;
use common\models\AdsRegionsRepository;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\web\Controller;
use dektrium\user\Finder;


class AdsController extends Controller
{
    /**
     * @var Finder
     */
    private $_profileFinder;

    /**
     * @var AdsRegionsRepository
     */
    private $_regionsRepository;

    /**
     * @var string
     */
    public $layout = 'account';

    /**
     * AdsController constructor.
     * @param string $id
     * @param Module $module
     * @param Finder $finder
     * @param AdsRegionsRepository $regionsRepository
     * @param array $config
     */
    public function __construct($id, Module $module, Finder $finder, AdsRegionsRepository $regionsRepository, array $config = [])
    {
        $this->_profileFinder = $finder;
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
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }



    /**
     * User advertising page
     *
     * @return string
     */
    public function actionIndex()
    {

        $id = \Yii::$app->user->getId();
        $profile = $this->_profileFinder->findProfileById($id);
        return $this->render('index', [
            'profile' => $profile,
            'regions' => $this->_regionsRepository->getRegions(),
            'regionsRepository' => $this->_regionsRepository
        ]);
    }

}
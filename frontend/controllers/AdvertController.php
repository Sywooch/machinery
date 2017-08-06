<?php


namespace frontend\controllers;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\helpers\ModelHelper;
use common\modules\language\models\LanguageRepository;
use yii\base\Module;


class AdvertController extends Controller
{
    public $languageRepository;
    public function __construct($id, Module $module, LanguageRepository $languageRepository, array $config = [])
    {
        $this->languageRepository = $languageRepository;
        parent::__construct($id, $module, $config);
    }

    public function actionCreate(){

        return $this->render('create', ['languages'=>$this->languageRepository->loadAllActive()]);
    }

    public function actionView(){
        return $this->render('view');
    }
}
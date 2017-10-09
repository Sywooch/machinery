<?php


namespace frontend\controllers;

use common\models\OrderPackage;
use common\models\OrderPackageRepository;
use Yii;
use common\helpers\ModelHelper;

use yii\web\NotFoundHttpException;
use common\modules\language\models\LanguageRepository;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\web\Controller;
use dektrium\user\Finder;
use backend\models\Pages;


class PageController extends Controller
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


    public function actionView($id)
    {
        if(!$model = Pages::find()->where(['id'=>$id])->one())
            throw new NotFoundHttpException('The requested page does not exist.');

        return $this->render('view', [
            'model'=>$model,
        ]);
    }


}
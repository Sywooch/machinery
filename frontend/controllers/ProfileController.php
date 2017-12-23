<?php

namespace frontend\controllers;

use common\modules\communion\models\CommunionMessage;
use common\modules\language\models\Message;
use dektrium\user\Finder;
use yii;
use common\models\User;
use dektrium\user\controllers\ProfileController as ProfileControllerBase;
use common\modules\file\Uploader;
use yii\helpers\Json;
use common\models\OrderPackage;
use common\models\TarifOptions;
use common\modules\communion\models\Communion;
use common\models\Viewed;



class ProfileController extends ProfileControllerBase
{
    /**
     * @var Uploader
     */
    private $_uploader;
    public $layout = 'account';

    public function __construct($id, \yii\base\Module $module, Finder $finder, Uploader $uploader, array $config = [])
    {
        $this->_uploader = $uploader;
        parent::__construct($id, $module, $finder, $config);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access']['rules'][] = ['allow' => true, 'actions' => ['photo-upload'], 'roles' => ['@']];
        $behaviors['access']['rules'][] = ['allow' => true, 'actions' => ['favorite', 'view'], 'roles' => ['@']];
        $behaviors['access']['rules'][] = ['allow' => true, 'actions' => ['published'], 'roles' => ['@']];
        $behaviors['access']['rules'][] = ['allow' => true, 'actions' => ['tarif'], 'roles' => ['@']];

        $behaviors['access']['rules'][] = ['allow' => true, 'actions' => ['im', 'communion'], 'roles' => ['@']];

        return $behaviors;
    }

    /**
     * @return string
     */
    public function actionPhotoUpload()
    {
        $model = User::findOne(Yii::$app->user->id);
        $avatar = $model->getAvatar()->one();
        if ($avatar) {
            $avatar->delete();
        }

        $this->_uploader->getInstances($model);

        if($this->_uploader->save($model)){

            return Json::encode([
                'files' => [
                    [
                        'name' => $model->avatar->name,
                        'size' => $model->avatar->size,
                        'url' => $model->avatar->path,
                        'thumbnailUrl' => $model->avatar->path.'/'.$model->avatar->name,
                        'deleteUrl' => '',
                        'deleteType' => 'POST',
                    ],
                ],
            ]);
        }

        return '';
    }

    public function actionView()
    {
        $id = \Yii::$app->user->getId();
        $profile = $this->finder->findProfile(['user_id' => $id])->one();

        if ($profile === null) {
            throw new NotFoundHttpException();
        }
        $viewed = Viewed::find()->where(['user_id'=>Yii::$app->user->id])->with(['advert'])->all();

        return $this->render('/user/profile/show', [
            'profile' => $profile,
            'viewed' => $viewed,
        ]);
    }

    /**
     * User favorite page
     *
     * @return string
     */
    public function actionFavorite()
    {
        $id = \Yii::$app->user->getId();
        $profile = $this->finder->findProfileById($id);
        return $this->render('/user/profile/favorite', ['profile' => $profile,]);
    }

    public function actionTarif(){
        $id = \Yii::$app->user->getId();
        $profile = $this->finder->findProfileById($id);
        if($model = OrderPackage::find()->where(['user_id' => $id])->with('package')->all()){
            foreach ($model as $item) {
//                dd($item->options);
//                dd(json_encode($item->options));
    //            $item->options = unserialize($model->options);
                //$item->options = TarifOptions::find()->where(['in', 'id', unserialize($item->options)])->all();
            }
        }

//        dd($model, 1);

        return $this->render('/user/profile/tarif', ['profile' => $profile, 'model'=>$model]);
    }

    public function actionCommunion(){
        $model = Communion::find()
            ->with(['messages', 'user', 'newMessages'])
            ->where(['user_id'=>Yii::$app->user->id])
            ->orWhere(['user_to'=>Yii::$app->user->id])
            ->orderBy('create_at DESC')
            ->all();

        return $this->render('/user/profile/communion', [
            'model'=>$model,
        ]);
    }
    public function actionIm($id){
        $model = Communion::find()->where(['id'=>$id])->with(['messages', 'messages.user'])->one();
//        dd($model);
        $message = new CommunionMessage();
        return $this->render('/user/profile/messages', [
            'model'=>$model,
            'message' => $message,
        ]);
    }
}

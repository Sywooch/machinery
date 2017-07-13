<?php

namespace frontend\controllers;

use dektrium\user\Finder;
use yii;
use common\models\User;
use dektrium\user\controllers\ProfileController as ProfileControllerBase;
use common\modules\file\Uploader;
use yii\helpers\Json;


class ProfileController extends ProfileControllerBase
{
    /**
     * @var Uploader
     */
    private $_uploader;

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

}

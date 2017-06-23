<?php

namespace frontend\controllers;

use yii;
use common\models\User;
use dektrium\user\controllers\ProfileController as ProfileControllerBase;
use common\modules\file\Uploader;
use yii\helpers\Json;


class ProfileController extends ProfileControllerBase
{
    /** @inheritdoc */
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

        Uploader::getInstances($model);

        if($model->save()){

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

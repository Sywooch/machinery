<?php

namespace common\modules\file\controllers;

use common\modules\realty\models\entity\Entity;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\modules\file\helpers\FileHelper;
use yii\web\NotFoundHttpException;
use common\modules\file\filestorage\Instance;

/**
 * Site controller
 */
class ManageController extends Controller
{
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
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @param $id
     * @param $token
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionDelete($id, $token)
    {
        $file = Instance::findOne($id);

        if (!$file || $token != FileHelper::getToken($file)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $file->delete();

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ['success' => true];
    }

}

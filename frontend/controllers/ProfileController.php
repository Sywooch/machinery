<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use dektrium\user\controllers\ProfileController as ProfileControllerBase;
use common\helpers\ModelHelper;
use common\modules\orders\models\Orders;

class ProfileController extends ProfileControllerBase
{
    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true, 
                        'actions' => ['index'], 
                        'roles' => ['@']
                    ],
                    [
                        'allow' => true, 
                        'actions' => ['show'], 
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->id == Yii::$app->request->get('id');
                        }
                    ],
                ],
            ],
        ];
    }
    
    public function actionShow($id)
    {
        $profile = $this->finder->findProfileById($id);

        if ($profile === null) {
            throw new NotFoundHttpException();
        }

        if(Yii::$app->request->isPost && $profile->user_id == Yii::$app->user->id){ 
           \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
           
           $attributes = $profile->attributes;
           $profile->load(Yii::$app->request->post());
    
          
           if($attributes != $profile->attributes){
               if($profile->validate()){
                   $profile->save();
                   return ['output' => current(Yii::$app->request->post(ModelHelper::getModelName($profile))), 'message' => ''];
               }else{
                   return ['output' => '', 'message' => current($profile->user->getErrors())[0]];
               }
           }
           
           $attributes = $profile->user->attributes;
           $profile->user->load(Yii::$app->request->post());
           
            if($attributes != $profile->user->attributes){
               $profile->user->scenario = 'update';
               if($profile->user->validate()){
                   $profile->user->save();
                   return ['output' => current(Yii::$app->request->post(ModelHelper::getModelName($profile->user))), 'message' => ''];
               }else{
                   return ['output' => '', 'message' => current($profile->user->getErrors())[0]];
               }
            }
        }

        return $this->render('show', [
            'profile' => $profile,
            'orders' => Orders::find()->where(['user_id' => $profile->user_id])->orderBy([
                'id' => SORT_DESC
            ])->all()
        ]);
    }
}

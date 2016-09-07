<?php

namespace frontend\modules\comments\controllers;

use yii;
use yii\web\Controller;
use yii\web\BadRequestHttpException;
use frontend\modules\comments\models\Comments;
use frontend\modules\comments\models\CommentsRepository;
use frontend\modules\comments\helpers\CommentsHelper;
use common\modules\file\models\File;

class DefaultController extends Controller {

	public function actionUpdate($id) {
		$model = Comments::findOne($id);

		if ($model->user_id == Yii::$app->user->id && $model->load(Yii::$app->request->post()) && $model->save()) {
                    $commentsRepository = new CommentsRepository();
                    return $this->renderPartial('_item', [
                            'comment' => $commentsRepository->getComment($model),
                            'model' => $model
                        ]);
		} elseif ($model->user_id == Yii::$app->user->id) {
                    $avatar = File::find()->where([
                        'entity_id' => Yii::$app->user->id,
                        'model' => 'Profile'
                    ])->one();
                    return $this->renderAjax('_form', [
                        'model' => $model,
                        'avatar' => $avatar
                    ]);
		}
	}

	public function actionAnswer($id, $token) {
                $model = Yii::$container->get(Comments::class);
                $parent = $model->findOne($id);
                if(CommentsHelper::getToken($parent->attributes) != $token){
                    throw new BadRequestHttpException(Yii::t('yii', 'Invalid token.'));
                }
                
                $model->parent_id = $parent->id; 
                $model->entity_id = $parent->entity_id; 
                $model->model = $parent->model; 

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
                        $commentsRepository = new CommentsRepository();
			return $this->renderPartial('_item', [
                                'comment' => $commentsRepository->getComment($model),
                                'model' => $model
                            ]);
		} else {
                        $avatar = File::find()->where([
                            'entity_id' => Yii::$app->user->id,
                            'model' => 'Profile'
                        ])->one();
			return $this->renderAjax('_form', [
                            'model' => $model,
                            'avatar' => $avatar
                                ]);
		}
	}

}

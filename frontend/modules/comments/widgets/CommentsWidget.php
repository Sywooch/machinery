<?php

namespace frontend\modules\comments\widgets;

use Yii;
use yii\helpers\ArrayHelper;
use yii\base\InvalidParamException;
use frontend\modules\comments\models\Comments;
use frontend\modules\comments\models\CommentsRepository;
use common\modules\file\models\File;


class CommentsWidget extends \yii\base\Widget {

        public $maxThread = 3;
        public $entity_id;
	public $model;

	public function init() {
		if (!$this->entity_id) {
			throw new InvalidParamException('Invalid param property: nid');
		}

		if (!$this->model) {
			throw new InvalidParamException('Invalid param property: model');
		}

                parent::init();
	}

	public function run() {

            $commentsRepository = Yii::$container->get(CommentsRepository::class);
            $model = Yii::$container->get(Comments::class);
            $model->setAttributes((array)$this);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                header('location: ' . Yii::$app->request->url); exit();
            } else {
              // print_r($model->getErrors()); exit();
            }

            $dataProvider = $commentsRepository->getCommentsList($model);
            $avatar = File::find()->where([
                    'entity_id' => Yii::$app->user->id,
                    'model' => 'Profile'
                ])->one();
            $comments = $dataProvider->getModels();            
            return $this->render('comments', [
                    'model' => $model,
                    'dataProvider' => $dataProvider,
                    'comments' => $dataProvider->getModels(),
                    'avatar' => $avatar,
                    'avatars' => ArrayHelper::index(File::findAll(array_column($comments, 'file_id')), 'id'),
                    'maxThread' => $this->maxThread
                ]);
	}

}

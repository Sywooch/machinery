<?php

namespace common\modules\comments\controllers;

use common\modules\comments\Comment;
use common\modules\comments\helpers\CommentsHelper;
use common\modules\comments\models\Comments;
use yii;
use yii\base\Module;
use yii\helpers\Html;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class CommentsController extends Controller
{

    /**
     * @var Comments
     */
    private $_comment;

    /**
     * CommentsController constructor.
     * @param string $id
     * @param Module $module
     * @param Comments $comment
     * @param array $config
     */
    public function __construct($id, Module $module, Comments $comment, array $config = [])
    {
        $this->_comment = $comment;
        parent::__construct($id, $module, $config);
    }

    /**
     *
     * Add new comment
     *
     */
    public function actionNew()
    {
        if ($this->_comment->load(Yii::$app->request->post()) && Comment::save($this->_comment)) {

            $this->sendEmail(Yii::$app->params['adminEmail'], $this->_comment);

            return $this->redirect(Yii::$app->request->referrer);
        } else {
            //   print_r($this->_comment->getErrors()); exit();
        }

    }

    /**
     *
     * Answer on comment
     *
     * @param $id
     * @param $token
     * @return string
     * @throws BadRequestHttpException
     */
    public function actionAnswer($id, $token)
    {
        if (CommentsHelper::getToken($id) != $token) {
            throw new BadRequestHttpException(Yii::t('yii', 'Invalid token.'));
        }

        $this->_comment->parent_id = $id;

        if ($this->_comment->load(Yii::$app->request->post()) && Comment::save($this->_comment)) {
            $this->sendEmail(Yii::$app->params['adminEmail'], $this->_comment);
            return $this->renderPartial('_item', [
                'comment' => $this->_comment,
                'maxThread' => $this->module->maxThread
            ]);
        } else {
            // print_r($this->_comments->getErrors()); exit();
        }

        return $this->renderAjax('_form', [
            'model' => $this->_comment,
        ]);

    }

    /**
     * @param $id
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionUpdate($id)
    {
        $model = Comments::findOne($id);

        if ($model->user_id != Yii::$app->user->id) {
            throw new ForbiddenHttpException();
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->sendEmail(Yii::$app->params['adminEmail'], $model);
            return $this->renderPartial('_item', [
                'comment' => $model,
                'maxThread' => $this->module->maxThread
            ]);
        } else {
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        }
    }


    /**
     * @param $email
     * @param $comment
     * @return bool
     */
    public function sendEmail($email, $comment)
    {
        if (!$email) {
            return;
        }

        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom(['noreply@test.ua' => 'KolesoFF'])
            ->setSubject('Новый отзыв')
            ->setTextBody(Html::encode($comment->comment))
            ->send();
    }

}

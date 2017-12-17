<?php

namespace common\modules\communion\controllers;

use Yii;
use yii\console\Controller;
use common\modules\communion\models\CommunionMessage;
use common\modules\communion\models\Communion;

class MessageController extends Controller
{

    /**
     *
     */
    public function actionIndex()
    {
        $this->module->getSearch()->getIndex()->run();
    }

    public function actionCreate()
    {
        if ($post = Yii::$app->request->post()) {
            $resp = ['status'=>'error'];

            $model = new CommunionMessage();
            if ($model->load($post)) {
                if (!$model->communion_id) {
                    $communion = (isset($post['Communion']['id']) && $post['Communion']['id']) ? Communion::findOne($post['Communion']['id']) : new Communion();

                    if ($communion->isNewRecord  && $communion->load($post)) {
                        $communion->subject = $communion->subject ? $communion->subject : Yii::t('app', 'No subject');
                        $communion->user_id = Yii::$app->user->id;
                        $communion->create_at = time();
                        $communion->status = Communion::ST_OPEN;
                    }
                    if($communion->save()){
                        $model->communion_id = $communion->id;
                    }
                }
                $model->create_at = time();
                $model->status = CommunionMessage::ST_NEW;
                $model->user_id = Yii::$app->user->id;
//                $model->user_to = $communion->user_to;


                if($model->save()){
                    $resp['status']  = 'success';
                    $resp['message'] = Yii::t('app', 'Successfully Sent');
                }
//                dd($model);
            }
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            return $resp;
        }
    }

}

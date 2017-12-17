<?php

namespace common\modules\notice\widgets;

use Yii;
use yii\bootstrap\Widget;
use common\modules\notice\models\Notice;

class NoticeWidget extends Widget
{
    private $_model;

    public function __construct($config = array())
    {

        parent::__construct($config);
    }

    public function run()
    {
        $model = Notice::find()->where(['status'=>0, 'user_id'=>Yii::$app->user->id])->all();
        return $this->render('notices', [
             'model' => $model,
        ]);
    }
}
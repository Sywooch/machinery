<?php
namespace common\modules\subscribe\widgets\Subscribe;
use yii;
use yii\bootstrap\Widget;
use common\modules\subscribe\models\Subscribe;

class SubscribeFormWidget  extends Widget
{

    public function run() {
        $model = new Subscribe();
        return $this->render('form', ['model' => $model]);
    }
}
<?php
use frontend\modules\comments\widgets\CommentsWidget;
use yii\helpers\StringHelper;
?>

<?=CommentsWidget::widget([
            'entity_id' => $model->id,
            'model' => StringHelper::basename(get_class($model)),
            'maxThread' => 4
    ]);

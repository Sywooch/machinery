<?php
use frontend\modules\comments\widgets\CommentsWidget;
use common\helpers\ModelHelper;
?>

<?=CommentsWidget::widget([
            'entity_id' => $model->id,
            'model' => ModelHelper::getModelName($model),
            'maxThread' => 4
    ]);

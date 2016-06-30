<?php

use yii\helpers\Html;

?>

<?= Html::activeLabel( $model, 'address');?>
<?= Html::activeDropDownList($model, 'address', $model->getAdderessList()); ?>
<?= Html::error($model, 'address', ['class' => 'help-block']); ?>


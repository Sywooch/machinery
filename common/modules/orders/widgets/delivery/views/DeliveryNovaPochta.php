<?php

use yii\helpers\Html;

?>

<?php foreach($model->attributes as $name => $value):?>
    <?= Html::activeLabel( $model, $name);?>
    <?= Html::activeTextInput($model, $name); ?>
    <?= Html::error($model, $name, ['class' => 'help-block']); ?>
<?php endforeach;?>



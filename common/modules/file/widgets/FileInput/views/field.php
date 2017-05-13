<?php

use common\modules\file\widgets\FileInput\Asset;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Json;

Asset::register($this);

$id = 'f' . $fieldId . '-' . time();

?>

<?= Html::activeFileInput($model, $attribute . '[]', ['id' => $id, 'multiple' => 'multiple']) ?>

<?php
$this->registerJs(
    "FileInputWidget.init('#" . $id . "'," . Json::encode($initialPreview) . "," . Json::encode($initialPreviewConfig) . ")",
    View::POS_END
);

?>



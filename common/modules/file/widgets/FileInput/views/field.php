<?php

use common\modules\file\widgets\FileInput\Asset;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Json;

Asset::register($this);

$id = 'f' . $fieldId . '-' . time();

?>

<span id="<?= $id ?>w">

    <?= Html::activeFileInput($model, $attribute . '[]', ['id' => $id, 'multiple' => 'multiple']) ?>

    <?php
    $this->registerJs(
        "FileInputWidget.init('#" . $id . "'," . Json::encode($initialPreview) . "," . Json::encode($initialPreviewConfig) . "," . ($showRemove ? 1 : 0) . ")",
        View::POS_END
    );

    ?>

</span>



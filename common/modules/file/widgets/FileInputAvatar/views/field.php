<?php

use common\modules\file\widgets\FileInputAvatar\Asset;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Json;

Asset::register($this);

$id = 'fa-' . time();

?>

<span id="<?= $id ?>w" class="file-input-avatar">

    <?= Html::activeFileInput($model, $attribute . '[]', ['id' => $id, 'data-browseLabel' => 'Upload new photo']) ?>

    <?php
    $this->registerJs(
        "FileInputAvatarWidget.init('#" . $id . "'," . Json::encode($initialPreview) . "," . Json::encode($initialPreviewConfig) . ",'" . $uploadUrl . "')",
        View::POS_END
    );

    ?>

</span>



<?php

use yii\helpers\ArrayHelper;

?>
<div class="banner-region banner-region-<?=$region ?>">
    <?php foreach ($models as $model): ?>
        <div class="banner">  <a href="<?= $model->url; ?>"><img src="<?= ArrayHelper::getValue($model,'banner.0.path'); ?>/<?= ArrayHelper::getValue($model,'banner.0.name'); ?>"></a></div>
    <?php endforeach; ?>
</div>

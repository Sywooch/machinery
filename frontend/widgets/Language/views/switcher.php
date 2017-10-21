<?php
/**
 *
 */
?>
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
   aria-expanded="false" ddd="<?= Yii::$app->language ?>"><img
        src="/images/langs/lang-<?= Yii::$app->language ?>.png" alt=""><?= Yii::t('app', 'CHANGE language') ?> <span
        class="caret"></span></a>
<ul class="dropdown-menu">
    <?php foreach ($model as $key => $val): ?>
        <li><a href="<?= \yii\helpers\Url::to(['/', 'language'=>$val->url] ) ?>"><img src="/images/langs/lang-<?= $val->local ?>.png" alt=""> <?= $val->url ?></a></li>
    <?php endforeach; ?>

</ul>

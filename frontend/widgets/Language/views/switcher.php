<?php
/**
 *
 */
$request = Yii::$app->request;
$params = $request->get();
array_unshift($params, Yii::$app->controller->id.'/'.Yii::$app->controller->action->id);

?>
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
   aria-expanded="false" ddd="<?= Yii::$app->language ?>">
    <img
        src="/images/langs/lang-<?= Yii::$app->language ?>.png" alt=""><?= Yii::t('app', 'CHANGE language') ?> <span
        class="caret"></span></a>
<ul class="dropdown-menu">
    <?php foreach ($model as $key => $val):
        $params['language'] = $val->url;
    ?>
        <li class="">
            <a href="<?= \yii\helpers\Url::to($params ) ?>"><img src="/images/langs/lang-<?= $val->local ?>.png" alt=""> <?= $val->url ?></a></li>
    <?php endforeach; ?>
</ul>

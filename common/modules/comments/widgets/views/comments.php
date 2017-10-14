<?php

use common\modules\comments\CommentsAsset;
use yii\widgets\LinkPager;
use common\modules\comments\helpers\CommentsHelper;
CommentsAsset::register($this);

?>

<div class="comments">

    <div class="comments-list">
        <a name="comments"></a>
        <?php if (empty($dataProvider->models)): ?>
            <div class="nocomments">Нет отзывов.</div>
        <?php else: ?>
            <?php foreach ($dataProvider->models as $comment): ?>
                <?= $this->render('_list', [
                    'comment' => $comment,
                    'entity' => $entity,
                    'maxThread' => $maxThread
                ]); ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <?= LinkPager::widget(['pagination' => $dataProvider->pagination]); ?>

    <?= $this->render('_form', [
        'model' => $model,
        'photo' => Yii::$app->user->isGuest ? '' : Yii::$app->user->identity->photo
    ]); ?>

</div>


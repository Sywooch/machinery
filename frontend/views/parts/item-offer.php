<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\modules\file\helpers\StyleHelper;
?>
<div class="offer-item flexbox">
    <!--                        <div class="_content _right">-->
    <header class="head-offer">
        <div class="col-md-12">
            <h3 class="h3"><a href="/object/<?=$entity->id?>"><?=Html::encode($entity->title);?></a></h3>
            <div class="_category-link"><a href="#">Вилочные погрузчики</a></div>
        </div>
    </header>
    <figure class="img-offer">
        <?php if (($file = ArrayHelper::getValue($entity->files, '0'))): ?>
            <?= Html::img(StyleHelper::getPreviewUrl($file, '193x144'), ['class' => 'img-responsive']); ?>
        <?php else: ?>
            <?= Html::img('/images/img-2.png', ['class' => 'img-responsive']); ?>
        <?php endif; ?>
    </figure>
    <div class="cf row-inner-offer _middle-inner">
        <div class="col-md-6"><i class="glyphicon glyphicon-phone"></i> <?=Yii::$app->formatter->asPhone($entity->phone)?></div>
        <div class="col-md-6"><i class="fa fa-envelope-open-o" aria-hidden="true"></i> mail@mail.com</div>
    </div>
    <div class="cf row-inner-offer _bottom-inner">
        <div class="col-md-6 _col-info">
            <div class="price"><?=Yii::$app->formatter->asCurrency($entity->price)?></div>
            <div class="_descr"><?php echo common\helpers\BfrStr::substr($entity->body, 50) ?></div>
        </div>
        <div class="col-md-6 _col-btn">
            <?= Html::a(Yii::t('app', 'Read more'), '/object/'.$entity->id, ['class'=>'btn btn-warning']) ?>
        </div>
    </div>
    <!--                        </div>-->
</div> <!-- .favorite-item -->
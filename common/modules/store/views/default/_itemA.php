<?php
use common\modules\store\helpers\CartHelper;
use yii\helpers\Html;
use common\modules\file\helpers\StyleHelper;
use yii\helpers\ArrayHelper;
use kartik\rating\StarRating;
use common\modules\store\helpers\ProductHelper;
use common\modules\store\helpers\CatalogHelper;

?>


<div class="item col-lg-4">

    <div class="img">
        <?php if (($file = ArrayHelper::getValue($product->files, '0'))): ?>
            <?= Html::a(Html::img(StyleHelper::getPreviewUrl($file, '250x250'), ['class' => 'img-responsive']), ['/' . $product->url->alias], ['class' => 'img']); ?>
        <?php else: ?>
            <?= Html::a(Html::img('/files/productdefault/photos/style/250x250/3129_12040_362427983415.jpg', ['class' => 'img-responsive']), ['/' . $product->url->alias], ['class' => 'img']); ?>
        <?php endif; ?>
    </div>

    <span class="product-status ">
                    <?php foreach (ProductHelper::getStatuses($product->terms) as $status): ?>
                        <span class="<?= $status->transliteration; ?>"><?= $status->name; ?></span>
                    <?php endforeach; ?>
                </span>

    <div class="clearfix">
        <div class="pull-left price">Цена:
            <strong><?php echo \Yii::$app->formatter->asCurrency($product->price); ?></strong></div>
        <div class="pull-right">
            <?= CartHelper::getBuyButton($product); ?>
            <img src="https://f.ua/statik/images/icons/h20px/motonew.png" alt="">
        </div>
    </div>
    <div class="clearfix rating-line">
        <a href="/<?= $product->groupUrl->alias; ?>/otzyvy" class="pull-left comments">
            <i class="fa fa-comment-o" aria-hidden="true"></i>
            <?= $product->comments; ?> отзыва
        </a>
        <?= StarRating::widget([
            'name' => 'rating_' . $product->id,
            'value' => $product->rating,
            'pluginOptions' => ['displayOnly' => true, 'size' => 'xs']
        ]);
        ?>
    </div>
    <div class="title">
        <?= Html::a(Html::encode(ProductHelper::titlePattern($product)), ['/' . $product->url->alias], []); ?>
    </div>
    <div class="produt-short"><?php echo Html::encode($product->short); ?></div>

</div>

<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use common\modules\file\helpers\StyleHelper;
use yii2mod\bxslider\BxSlider;
use common\modules\store\helpers\CartHelper;
use common\modules\store\helpers\CatalogHelper;

?>

<div class="row">
    <div class="col-lg-5">
        <div class="produt-gallery">
            <?php
            $items = [];
            foreach ($entity->files as $file) {
                $items[] = Html::img(StyleHelper::getPreviewUrl($file, '700x700'), ['class' => 'img-responsive']);
            }

            echo BxSlider::widget([
                'pluginOptions' => [
                    'maxSlides' => 1,
                    'speed' => 300,
                    'controls' => true,
                    'slideWidth' => 450,
                    //'adaptiveHeight' => true,
                    'pagerCustom' => '#bx-pager',
                    'onSliderLoad' => new yii\web\JsExpression('
                function() {

                },
            ')
                ],
                'items' => $items
            ]);

            ?>
            <div id="bx-pager">
                <?php foreach ($entity->files as $index => $file): ?>
                    <a data-slide-index="<?= $index ?>"
                       href=""> <?= Html::img(StyleHelper::getPreviewUrl($file, '100x100'), []); ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="row">
            <div class="col-lg-5">


                <section class="buy-block">
                    <div class="price"><?php echo \Yii::$app->formatter->asCurrency($entity->price); ?></div>
                    <?php echo CartHelper::getBuyButton($entity); ?>
                    <div class="controls">
                        <?php echo CatalogHelper::getCompareButton($entity); ?>
                        <?php echo CatalogHelper::getWishButton($entity); ?>
                    </div>
                </section>


            </div>
            <div class="col-lg-7">

                <div>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Киев и пригород</a></li>
                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Другие города</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="home">11</div>
                        <div role="tabpanel" class="tab-pane" id="profile">222</div>
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>


<div class="produt-short">
    <?= Html::encode($entity->specification); ?>
</div>

<div class="body ">
    <?=
    HtmlPurifier::process($entity->description, [
        'HTML.AllowedElements' => ['p', 'br', 'b', 'ul', 'li'],
        'AutoFormat.AutoParagraph' => true
    ]);
    ?>
</div>


<div class="characteristic">
    <?php foreach ($entity->feature as $name => $features): ?>
        <h3><?= $name ?></h3>
        <ul>
            <?php foreach ($features as $items): ?>
                <li>
                    <span><?= $items->name ?></span>
                    <span><?= $items->value ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endforeach; ?>
</div>
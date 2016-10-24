<?php
use frontend\modules\cart\helpers\CartHelper;
use yii\helpers\Html;
use common\modules\file\helpers\StyleHelper;
use yii\helpers\ArrayHelper;
use kartik\rating\StarRating;
use common\modules\product\helpers\ProductHelper;
use frontend\modules\catalog\helpers\CatalogHelper;
?>

<div class="item">
            <div class="left">
                <?= StarRating::widget([
                            'name' => 'rating_'.$product->id,
                            'value' => $product->rating,
                            'pluginOptions' => ['displayOnly' => true, 'size' => 'xs']
                        ]);
                ?>
                <?php if(($file = ArrayHelper::getValue($product->files, '0'))):?>
                    <?=Html::a(Html::img('/'.StyleHelper::getPreviewUrl($file, '130x130'),['class' => 'img-responsive']),['/'.$product->url->alias],['class' => 'img']);?>
                <?php else:?>
                    <?=Html::a(Html::img('/files/nophoto_100x100.jpg',['class' => 'img-responsive']),['/'.$product->url->alias],['class' => 'img']);?>
                <?php endif;?>
                <span class="comments-count">
                    
                    <a href="/<?=$product->groupUrl->alias;?>/otzyvy">
                        <i class="glyphicon glyphicon-comment"></i>
                        <?=$product->comments;?> отзыва
                    </a>
                </span>
            </div>
            <div class="right">
                <span class="product-status ">
                        <?php foreach(ProductHelper::getStatuses($product->terms) as $status):?>
                            <span class="<?=$status->transliteration;?>"><?=$status->name;?></span>
                        <?php endforeach;?>
                </span>
                <?=Html::a(Html::encode($product->name), ['/'.$product->url->alias],['class'=>'title']); ?>
                <div class="produt-short"><?php echo Html::encode($product->short); ?></div>
                <div class="price-conteiner">
                    <span class="price"><?php echo \Yii::$app->formatter->asCurrency($product->price); ?></span>
                    
                    <?= CartHelper::getBuyButton($product);?>
                    <?= CatalogHelper::getCompareButton($product, $compareIds);?>
                    
                </div>
            </div>
</div>    
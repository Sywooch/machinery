<?php
use yii\helpers\Html;
use frontend\modules\cart\Asset as CartAsset;
use frontend\modules\cart\helpers\CartHelper;
use common\modules\product\Asset as ProductAsset;
use common\modules\product\helpers\ProductHelper;
use kartik\rating\StarRating;
use yii\widgets\Breadcrumbs;


ProductAsset::register($this);
CartAsset::register($this);

$map = [
    'otzyvy' => 'Отзывы'
];


$this->title = isset($tab) ? $product->title . ' ' . $map[$tab] : Html::encode($product->titleDescription);
$this->params['breadcrumbs'] = ProductHelper::getBreadcrumb($product);
?>

<div class="row product">
    <div class="col-lg-8 left">
        <div class="clearfix">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>

            <span class="sku"><?=Html::encode($product->sku);?></span>
            <?= StarRating::widget([
                'name' => 'rating_35',
                'value' => $product->rating,
                'pluginOptions' => ['displayOnly' => true, 'size' => 'xs']
            ]);
            ?>
            <div class="print-wrapper" onclick="window.print();"><span class="glyphicon glyphicon-print"></span><a>Распечатать</a></div>
        </div>
        
        

        
        
        <h1><?=Html::encode($this->title);?></h1>
        <div class="btn-group custom" role="group" aria-label="...">
            <a type="button" class="btn btn-default" href="/<?=$product->url->alias?>">Характеристики</a>
            <a type="button" class="btn btn-default" href="/<?=$product->groupAlias->alias?>/otzyvy">Отзывы</a>
        </div>

        <?php if(isset($tab)):?>
            <?=$this->render('_'.$tab,[
                'model' => $product,
                'products' => $products
            ]);?>
        <?php else:?>
            <?=$this->render('_main',[
                'model' => $product,
            ]);?>
        <?php endif; ?>
        
        
        
        
    </div>
    <div class="col-lg-4 ">
        
        <aside>
            <section class="buy-block">
                <div class="inline">
                    <div class="price"><?php echo \Yii::$app->formatter->asCurrency($product->price); ?></div>
                </div>
                <div class="inline">
                    <?php echo CartHelper::getBuyButton($product);?>
                </div>   
            </section>
        </aside>
        
        
    </div>
</div>

<?=CartHelper::getConfirmModal();?> 
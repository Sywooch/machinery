<?php
use yii\helpers\Html;
use common\modules\store\CartAsset;
use common\modules\store\helpers\CartHelper;
use common\modules\store\helpers\ProductHelper;
use common\modules\store\helpers\CatalogHelper;
use kartik\rating\StarRating;
use yii\widgets\Breadcrumbs;


CartAsset::register($this);

$map = [
    'otzyvy' => 'Отзывы'
];


$this->title = isset($tab) ? $product->title . ' ' . $map[$tab] : ProductHelper::titlePattern($product);
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
            <div class="print-wrapper" onclick="window.print();"><span class="print-icon"></span><a>Распечатать</a></div>
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
            <section class="buy-block">
                <div class="inline">
                    <?php echo CatalogHelper::getCompareButton($product);?>
                </div> 
                <div class="inline">
                    <?php echo CatalogHelper::getWishButton($product);?>
                </div> 
            </section>
        </aside>
        
        
    </div>
</div>

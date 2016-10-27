<?php

use yii\helpers\Html;
use kartik\checkbox\CheckboxX;
use common\modules\product\helpers\ProductHelper;
use common\modules\file\helpers\StyleHelper as Style;
use common\modules\orders\helpers\OrdersHelper;

?>

<?php foreach($wishList as $item):?>
<?php $model = $models[$item->model][$item->entity_id];?>
<div class="row table-list-item " id="order-item-<?=$model->id?>">
    <div class="col-lg-2 col-md-2 col-sm-2 ">
   
            <?=CheckboxX::widget([
                'name'=>'chb_'.$item->id,
                'options'=>['id'=>'chb_'.$item->id, 'class' => 'chb', 'data-id' => $item->id],
                'pluginOptions' => ['size'=>'xs', 'threeState' => false]
            ]);?>

        <?php 
        if(isset($model->photos) && !empty($model->photos)){
            $img = Html::img('/'.Style::getPreviewUrl($model->photos[0], '100x100'), ['class' => 'img-responsive']);
        }else{
            $img = Html::img('/files/nophoto_100x100.jpg',['class' => 'img-responsive']);
        }
        ?>
        <?= Html::a($img, ['/'.$model->url->alias], ['class' => '']); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <span class="product-status ">
                <?php foreach(ProductHelper::getStatuses($model->terms) as $status):?>
                    <span class="<?=$status->transliteration;?>"><?=$status->name;?></span>
                <?php endforeach;?>
        </span>
        <?= Html::a($model->title, ['/'.$model->url->alias], ['class' => '']); ?>
        <div class="info">
            <div class="sku">
                <span class="lb">Код</span>
                <?=$model->sku;?>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4" style="text-align:center;">
        <a href="/user/<?=Yii::$app->user->id;?>/wish/remove/<?=$item->id?>" class="item-remove cart-item-remove"><i class="glyphicon glyphicon-remove-circle"></i></a>
        <span class="item-total">
                <?=  Yii::$app->formatter->asCurrency($model->price);?>
        </span>
    </div>
</div>

<?php endforeach;?>

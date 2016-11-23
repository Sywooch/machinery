<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use yii\jui\AutoComplete;
use yii\helpers\Url;
use yii\web\JsExpression;
use common\modules\orders\PromoAsset;
use common\helpers\ModelHelper;

PromoAsset::register($this);

/* @var $this yii\web\View */
/* @var $model backend\models\ProductDefault */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Product', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-phone-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        
        <?php
            Modal::begin([
                'header' => '<h2>Add promo code</h2>',
                'toggleButton' => ['label' => 'Promo','class' => 'btn btn-primary'],
            ]);
        ?>    

        <?=AutoComplete::widget([
            'name'=>'name',
            //'model' => $promoCodes,
           // 'attribute' => 'code',
            'clientOptions' => [
                    'source' =>Url::toRoute('/orders/promo-codes/find-ajax'),
                    'dataType'=>'json',
                    'autoFill'=>true,
                    'minLength' => '1',
                    'select' =>new JsExpression("function(event, ui) {
                        this.value = ui.item.name + 'бл. ' + ui.item.blok_num;
                    }"),
            ],
            'options'=>[
                'id' => 'add-code',
                'class'=>'form-control',
                'placeholder' => 'AAA-AAA-AAA'
            ]
        ]);
        ?> 
        <br/>
        <div class="form-group">
            <?= Html::submitButton( 'add', ['class' =>  'btn btn-primary', 'onClick' => "promo.add($('#add-code'),'".$model->id."','".ModelHelper::getModelName($model)."');"]) ?>
        </div>
        <?php Modal::end(); ?>
    </p>
    
    <?php if(isset($model->promo)):?>
    <?php
        $code = $model->promo->code;
        echo DetailView::widget([
            'model' => $code,
            'attributes' => [
                'id',
                'code',
                'count',
                'discount',
                [
                    'label'  => 'time',
                    'value'  => $code->time->format('Y-m-d H:i:s'),
                ],
                [
                    'label'  => 'action',
                    'value'  => Html::a("view", ['/product/promo-products/view', 'id' => $model->promo->id]),
                    'format'=>'raw'
                ],
            ],
        ]); 
  
    ?>
    <?php endif;?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'group',
            'source_id',
            'user_id',
            'sku',
            'available',
            'price',
            'rating',
            'created',
            'updated',
            'title',
            'short',
            'description:ntext'
        ],
    ]) ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\modules\orders\helpers\OrdersHelper;

/* @var $this yii\web\View */
/* @var $model common\modules\orders\models\Orders */

$this->title = 'Оформление заказа';
$this->params['breadcrumbs'][] = ['label' => 'Оформление', 'url' => ['/orders']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'email',
            'phone',
            'address',
            'payment',
            'delivery',
        ],
    ]) ?>
    
    <h1><?= Html::tag('h2','Информация по доставке') ?></h1>
    
    <?php
        $deliveryModel = $model->deliveryInfo->getModel();
    ?>
    <?= DetailView::widget([
        'model' => $deliveryModel,
        'attributes' => array_keys($deliveryModel->attributes),
    ]) ?>
    
    <?=Html::a('Оформить',['confirm'], ['class' =>'btn btn-primary pull-right', 'data-method' => 'post'])?>

</div>

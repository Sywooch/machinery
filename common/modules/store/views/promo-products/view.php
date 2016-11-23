<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


/* @var $this yii\web\View */
/* @var $model common\modules\product\models\PromoProducts */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Promo Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="promo-products-view">

    <h1><?= Html::encode($model->productTitle) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'code_id',
            'code.code',
            'code.count',
            'code.discount',
            [
                'label'  => 'time',
                'value'  => $model->code->time->format('Y-m-d H:i:s'),
            ],
            'entity_id',
            'model',
            'productTitle'
        ],
    ]) ?>

</div>

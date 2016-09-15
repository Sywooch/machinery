<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\modules\product\models\PromoCodes */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Promo Codes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="promo-codes-view">

    <h1><?= Html::encode($model->code) ?></h1>

    <p>
      
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
            'code',
            'count',
            'discount',
            'time',
        ],
    ]) ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\product\models\ProductShortSettings */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Product Short Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-short-settings-view">

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
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'vocabulary_id',
            'title',
        ],
    ]) ?>

</div>

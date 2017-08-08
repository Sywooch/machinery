<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AdsRegions */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Ads Regions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ads-regions-view">

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
            'name',
            'price_front',
            'price_category',
            'price_subcategory',
            'status',
            'banner_count',
            'transliteration',
        ],
    ]) ?>

</div>

<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AdsRegionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ads Regions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ads-regions-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Ads Regions', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'price_front',
            'price_category',
            'price_subcategory',
            // 'status',
            // 'banner_count',
            // 'transliteration',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

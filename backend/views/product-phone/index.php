<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductPhoneSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Product Phones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-phone-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Product Phone', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
          //  ['class' => 'yii\grid\SerialColumn'],

            'id',
           // 'group_id',
           // 'source_id',
            'user_id',
            'sku',
            'available',
            'price',
            // 'rating',
            // 'publish',
            // 'created',
            // 'updated',
             'title',
            // 'short',
            // 'description:ntext',
            // 'data:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

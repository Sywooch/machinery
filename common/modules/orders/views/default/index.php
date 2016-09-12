<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CartOrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */



$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cart-orders-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // $this->render('_search', ['model' => $searchModel]); ?>



    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            'email:email',
            'phone',
            'address:ntext',
            'comment:ntext',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {                      
                        return $model->statuses[$model->status];
                },
            ],
            [ 'class' => 'yii\grid\ActionColumn',
               'template' => '{view} {delete} ' 
            ],
            
        ],
    ]);
    ?>
            
                   

</div>

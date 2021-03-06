<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\payment\models\PaymentAccountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payment Accounts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-account-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Payment Account', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'balance',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

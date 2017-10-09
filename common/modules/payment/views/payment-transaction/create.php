<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\payment\models\PaymentTransaction */

$this->title = 'Create Payment Transaction';
$this->params['breadcrumbs'][] = ['label' => 'Payment Transactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-transaction-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

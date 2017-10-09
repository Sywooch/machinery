<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\payment\models\PaymentAccount */

$this->title = 'Update Payment Account: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Payment Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="payment-account-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

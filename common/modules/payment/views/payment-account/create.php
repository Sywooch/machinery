<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\payment\models\PaymentAccount */

$this->title = 'Create Payment Account';
$this->params['breadcrumbs'][] = ['label' => 'Payment Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-account-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

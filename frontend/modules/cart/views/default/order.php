<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\orders\models\Orders */

$this->title = 'Оформление заказа';
$this->params['breadcrumbs'][] = ['label' => 'Оформление', 'url' => ['/orders']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>

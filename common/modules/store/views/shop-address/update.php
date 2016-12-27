<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\orders\models\ShopAddress */

$this->title = 'Update Shop Address: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Shop Addresses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="shop-address-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

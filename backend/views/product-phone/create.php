<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ProductPhone */

$this->title = 'Create Product Phone';
$this->params['breadcrumbs'][] = ['label' => 'Product Phones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-phone-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

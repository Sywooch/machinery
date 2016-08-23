<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\product\models\ProductShortSettings */

$this->title = 'Update Product Short Settings: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Product Short Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-short-settings-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\product\models\PromoProducts */

$this->title = 'Update Promo Products: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Promo Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="promo-products-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AdsActions */

$this->title = 'Update Ads Actions: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Ads Actions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ads-actions-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

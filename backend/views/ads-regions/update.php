<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AdsRegions */

$this->title = 'Update Ads Regions: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Ads Regions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ads-regions-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AdsBanners */

$this->title = 'Update Ads Banners: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Ads Banners', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ads-banners-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'regions' => $regions,
        'catalog' => $catalog
    ]) ?>

</div>

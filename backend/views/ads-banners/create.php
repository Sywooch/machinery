<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\AdsBanners */

$this->title = 'Create Ads Banners';
$this->params['breadcrumbs'][] = ['label' => 'Ads Banners', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ads-banners-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'regions' => $regions,
        'catalog' => $catalog
    ]) ?>

</div>

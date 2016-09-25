<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\AdsSlider */

$this->title = 'Create Ads Slider';
$this->params['breadcrumbs'][] = ['label' => 'Ads Sliders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ads-slider-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

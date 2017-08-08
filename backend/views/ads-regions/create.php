<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\AdsRegions */

$this->title = 'Create Ads Regions';
$this->params['breadcrumbs'][] = ['label' => 'Ads Regions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ads-regions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

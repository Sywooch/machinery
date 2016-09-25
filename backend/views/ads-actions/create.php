<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\AdsActions */

$this->title = 'Create Ads Actions';
$this->params['breadcrumbs'][] = ['label' => 'Ads Actions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ads-actions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

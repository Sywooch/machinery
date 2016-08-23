<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\BrandInfo */

$this->title = 'Create Brand Info';
$this->params['breadcrumbs'][] = ['label' => 'Brand Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-info-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

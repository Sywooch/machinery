<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TarifOptions */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Tarif Options',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tarif Options'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="tarif-options-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\communion\models\Communion */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Communion',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Communions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="communion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

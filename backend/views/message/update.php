<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\communion\models\CommunionMessage */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Communion Message',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Communion Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="communion-message-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
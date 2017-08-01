<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TarifOptions */

$this->title = Yii::t('app', 'Create Tarif Options');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tarif Options'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tarif-options-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Advert */
/*
 * @var @languages
 */

$this->title = Yii::t('app', 'Create Advert');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Adverts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advert-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'languages' => $languages,
        'categories' => $categories,
        'manufacturer' => $manufacturer
    ]) ?>

</div>

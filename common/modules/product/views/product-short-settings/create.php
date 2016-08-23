<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\product\models\ProductShortSettings */

$this->title = 'Create Product Short Settings';
$this->params['breadcrumbs'][] = ['label' => 'Product Short Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-short-settings-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

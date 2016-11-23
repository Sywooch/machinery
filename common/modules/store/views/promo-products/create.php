<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\product\models\PromoProducts */

$this->title = 'Create Promo Products';
$this->params['breadcrumbs'][] = ['label' => 'Promo Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="promo-products-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\orders\models\ShopAddress */

$this->title = 'Create Shop Address';
$this->params['breadcrumbs'][] = ['label' => 'Shop Addresses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shop-address-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

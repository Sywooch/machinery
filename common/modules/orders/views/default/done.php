<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\modules\orders\helpers\OrdersHelper;

/* @var $this yii\web\View */
/* @var $model common\modules\orders\models\Orders */

$this->title = 'Заказ оформлен';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <code><?= __FILE__ ?></code>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;


$this->title = Html::encode('Сравнение');
$this->params['breadcrumbs'][] = $this->title;

?>
<?= Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]) ?>
<h1><?=$this->title;?></h1>

Нет продуктов для сравнения

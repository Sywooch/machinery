<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;


$this->title = Html::encode('Список желаний');
$this->params['breadcrumbs'][] = ['label' => $user->profile->name ? $user->profile->name : $user->username, 'url' => '/user/'.$user->id];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]) ?>
<h1><?=$this->title;?></h1>

<div>Пока еще не добавлено продуктов</div>

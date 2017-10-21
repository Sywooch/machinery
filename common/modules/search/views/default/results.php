<?php

use yii\helpers\Html;

$this->title = 'Результаты поиска';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container search-results">
    <?php foreach ($dataProvider->models as $model): ?>
        <div><?= Html::encode($model->title); ?></div>
    <?php endforeach; ?>
    <?= \yii\widgets\LinkPager::widget([
        'pagination' => $dataProvider->pagination,
    ]); ?>
</div>
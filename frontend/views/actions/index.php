<?php

use yii\bootstrap\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\Breadcrumbs;


$this->title = 'Обзоры новинок';
$this->params['breadcrumbs'][] = Html::encode($this->title);

?>

<?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []]) ?>

<div class="reviews reviews-full">
    <h1>Обзоры новинок</h1>
    <?php foreach($models as $model): ?>
       <div class="review-item">
           <?= Html::a(Html::img('/'.$model->image[0]->path.'/'.$model->image[0]->name),[$model->url->alias]);?>
           <div class="date"><?=Yii::$app->formatter->asDate($model->created_at, 'php:d F');?></div>
           <?= Html::a(Html::encode($model->title),[$model->url->alias],['class' => 'title']);?>
           <div class="body"><?= HtmlPurifier::process($model->short, [
                   'HTML.AllowedElements' => [],
                   'AutoFormat.AutoParagraph' => false
               ]);
           ?>
           </div>
       </div>
   <?php endforeach; ?>
</div>
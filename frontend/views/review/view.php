<?php
use yii\bootstrap\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\Breadcrumbs;


$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Обзоры', 'url' => '/review'];
$this->params['breadcrumbs'][] = Html::encode($model->title);

?>

 <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []]) ?>
<div class="review-view">
    <h1><?=Html::encode($model->title)?></h1>
    <div class="date"><?=Yii::$app->formatter->asDate($model->created_at, 'php:d F');?></div>
    <div class="body">
        <?= HtmlPurifier::process($model->short, [
                       'HTML.AllowedElements' => ['p','a','br','span','b','i','img'],
                       'AutoFormat.AutoParagraph' => false
                   ]);
        ?>
    </div>
</div>
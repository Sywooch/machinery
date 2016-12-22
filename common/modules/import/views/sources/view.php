<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\modules\import\models\Sources */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Sources', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sources-view">

    <h1><?= Html::encode($this->title) ?></h1>



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'type',
            'url:url',
            'tires',
            'status',
            'date:datetime',
            [
                'label' => 'Messages',
                'value' => call_user_func(function ($model) {
                    return $model->messages ? implode('<br />', json_decode($model->messages)) : '';
                }, $model),
                'format' => 'html'        
            ]
        ],
    ]) ?>

</div>

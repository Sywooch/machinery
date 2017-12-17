<?php

use common\modules\language\helpers\LanguageHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use common\modules\language\LanguageAsset;

LanguageAsset::register($this);

$this->title = 'Source Messages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="source-message-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Source Message', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],

            'id',
            'message:ntext',
            'category',
            [
                'attribute' => 'translation',
                'value' => function ($model) use($languages){
                   return LanguageHelper::createTranslateFields($model, $languages);
                },
                'format' => 'raw'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

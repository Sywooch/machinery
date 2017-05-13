<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\modules\taxonomy\models;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\taxonomy\models\TaxonomyVocabularySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Taxonomy Vocabularies';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="taxonomy-vocabulary-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Taxonomy Vocabulary', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',

            [   'class' => 'yii\grid\ActionColumn',
                'template' => '{list} {hierarchy} {update} {delete}',
                'buttons' => [
                    'list' => function ($url, $model) {
                        return Html::a('<i class="glyphicon glyphicon-list-alt"></i>', '/taxonomy/items?TaxonomyItemsSearch[vid]=' . $model->id, [
                                'title' => Yii::t('yii', 'List'),
                        ]);
                    },
                    'hierarchy' =>  function ($url, $model) {
                        return Html::a('<i class="glyphicon glyphicon-align-right"></i>', '/taxonomy/items/hierarchy/?TaxonomyItemsHierarchy[vid]=' . $model->id, [
                            'title' => Yii::t('yii', 'Hierarchy'),
                        ]);
                    },      
                    'delete' => function ($url, $model) {
                        if($model->countTerms()) return false; 
                        return Html::a('<i class="glyphicon glyphicon-trash"></i>', $url, [
                            'data-method' => 'post',
                            'data-confirm' => Yii::t('user', 'Are you sure to delete this vocabulary?'),
                            'title' => Yii::t('yii', 'Delete'),
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>

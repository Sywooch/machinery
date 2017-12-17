<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\taxonomy\models\TaxonomyItemsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Taxonomy Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="taxonomy-items-index backend__">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
       <?= Html::a('Create', ['create?TaxonomyItems[vid]=' . $searchModel->vid], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'icon_name',
            'transliteration',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}'
            ],
        ],
    ]); ?>
</div>

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\modules\taxonomy\models\TaxonomyItems */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Taxonomy Items', 'url' => ['/taxonomy/items?TaxonomyItemsSearch[vid]='.$model->vid]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="taxonomy-items-view">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'vid',
            'pid',
            'name',
            'transliteration',
            'weight',
        ],
    ]) ?>

</div>

<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\taxonomy\models\TaxonomyItems */

$this->title = 'Create Taxonomy Items';
$this->params['breadcrumbs'][] = ['label' => 'Taxonomy Items', 'url' => ['/taxonomy/items?TaxonomyItemsSearch[vid]='.$model->vid]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="taxonomy-items-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'parentTerm' => $parentTerm,
        'languages' => $languages
    ]) ?>

</div>

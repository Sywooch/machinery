<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\modules\taxonomy\Asset;
use common\modules\taxonomy\helpers\TaxonomyHelper;

Asset::register($this); 

$this->title = 'Hierarchy';
$this->params['breadcrumbs'][] = ['label' => 'Taxonomy Vocabularies','url' => '/admin/taxonomy/vocabulary'];
$this->params['breadcrumbs'][] = 'Ordering'; 


?>
<div class="taxonomy-items-index clearfix">

    <h1><?= Html::encode($this->title) ?></h1>
    
<?php if($model->vid):?>
    
    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
        <?= Html::submitButton( 'Save', ['class' => 'btn btn-primary']) ?> 
    </div>
    

    <?php ActiveForm::end(); ?>
   
    
    
    <div class="dd" id="tree"></div>
    
 
    <script>
        var tree = <?= json_encode(TaxonomyHelper::toArray($model->tree)) ?>;
        var vocabularyId = <?= $model->vid;?>;
        var parentId = <?= $model->parent ? $model->parent->pid : 0;?>;
    </script>
   
  <?php endif; ?>
</div>

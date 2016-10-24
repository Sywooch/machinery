<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\modules\taxonomy\Asset;

Asset::register($this); 

/* @var $this yii\web\View */
/* @var $searchModel app\models\TaxonomyItemsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Hierarchy';
$this->params['breadcrumbs'][] = ['label' => 'Taxonomy Vocabularies','url' => '/admin/taxonomy/vocabulary'];
$this->params['breadcrumbs'][] = 'Ordering'; 


?>
<div class="taxonomy-items-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
<?php if($model->vid):?>
    
    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
        <?= Html::submitButton( 'Save', ['class' => 'btn btn-primary']) ?> 
    </div>
    

    <?php ActiveForm::end(); ?>
   
    
    
    <div class="dd" id="tree"></div>
    
 
    <script>
        var tree = <?= json_encode($tree) ?>;
        var vocabularyId = <?= $vocabularyId;?>;
        var parentId = <?= $parentTerm?$parentTerm->pid:0;?>;
    </script>
   
  <?php endif; ?>
</div>

<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use frontend\modules\catalog\helpers\CatalogHelper;
use frontend\modules\cart\helpers\CartHelper;

$this->title = Html::encode('Сравнение');
$this->params['breadcrumbs'][] = $this->title;

?>
<?= Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]) ?>
<h1><?=$this->title;?></h1>

<?php foreach($terms as $term):?>
    <a class="cmpare-category <?=($current->id == $term->id) ? 'active':'';?>" href="/catalog/compare?id=<?=$term->id?>"><?=$term->name?></a>
<?php endforeach; ?>


    <table class="compare-table characteristic">
    <tr>
        <td></td>
        <?php foreach($models as $model):?>
        <td><?=$this->render('_item', ['product' => $model]); ?></td>
        <?php endforeach;?>   
    </tr>
<?php foreach(CatalogHelper::compareFeatures($models) as $title => $items):?>
    <tr>
        <td class="lb"><h3><?=$title;?></h3></td>
        <?php for($i=0; $i<count($models); $i++):?> 
        <td></td>
        <?php endfor;?>
    </tr>
    <?php foreach($items as $name => $values):?>
    <tr>
        <td><?=$name;?></td>
        <?php foreach($models as $model):?>
        <td><?=isset($values[$model->id])?$values[$model->id]:'-';?></td>
        <?php endforeach;?>
    </tr>
    <?php endforeach;?>
<?php endforeach;?>
</table>    
    
<?=CartHelper::getConfirmModal();?>
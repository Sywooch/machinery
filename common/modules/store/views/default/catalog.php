<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\modules\taxonomy\helpers\TaxonomyHelper;

$this->title = 'Каталог';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]) ?>
<h1><?=$this->title;?></h1>
<div class="row catalog-category-list ">
    <?php foreach($menuItems as $index => $mainItem):?>
    <div class="col-lg-3">
        <?=Html::a($mainItem['name'], ['/catalog', 'menu' => [$mainItem]], ['class'=> 'link_side-menu']);?>
        <?php if(isset($mainItem['children'])):?>
        <?php $childrens = TaxonomyHelper::nes2Flat($mainItem['children']); ?>
        <div class="subcategory-list_products " > 
            <?php foreach($childrens as $childrenItem):?>
                <?php if($mainItem['id'] == $childrenItem['pid']):?>
                    <?=Html::a($childrenItem['name'], ['/catalog','menu' => [$mainItem, $childrenItem]], ['class'=> 'subcategory-list-item__link']);?>
                <?php endif; ?>
            <?php endforeach;?>
        </div>
        <?php endif;?> 
    </div>
    <?php endforeach; ?>
</div>





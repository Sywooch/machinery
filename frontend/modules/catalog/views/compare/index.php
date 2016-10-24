<?php

use frontend\modules\catalog\helpers\CatalogHelper;
?>


<?php foreach($terms as $term):?>
    <a href="/catalog/compare?id=<?=$term->id?>"><?=$term->name?></a>
<?php endforeach; ?>


<table>
    <tr>
        <td></td>
        <?php foreach($models as $model):?>
        <td><?=$this->render('_item', ['product' => $model]); ?></td>
        <?php endforeach;?>   
    </tr>
<?php foreach(CatalogHelper::compareFeatures($models) as $title => $items):?>
    <tr>
        <td><strong><?=$title;?></strong></td>
        <?php for($i=0; $i<count($models); $i++):?>
        <td></td>
        <?php endfor;?>
    </tr>
    <?php foreach($items as $name => $values):?>
    <tr>
        <td><?=$name;?></td>
        <?php for($i=0; $i<count($models); $i++):?>
        <td><?=isset($values[$i])?$values[$i]:'';?></td>
        <?php endfor;?>
    </tr>
    <?php endforeach;?>
<?php endforeach;?>
</table>    
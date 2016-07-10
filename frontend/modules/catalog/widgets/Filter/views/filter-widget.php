<?php
use frontend\modules\catalog\widgets\Filter\Asset;
use yii\helpers\Html;

Asset::register($this);

?>

<?php foreach($vocabularies as $vocabulary): ?>
    <?php if(isset($filterItems[$vocabulary->id])):?>
        <h2><?=$vocabulary->name;?></h2>
        <?php foreach($filterItems[$vocabulary->id] as $items): ?>
            <div><?=$items['name'];?>(<?=$items['items'];?>)</div>
        <?php endforeach; ?>
    <?php endif;?>
<?php endforeach; ?>


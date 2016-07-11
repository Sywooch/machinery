<?php
use frontend\modules\catalog\widgets\Filter\Asset;

use yii\helpers\Url;
use frontend\modules\catalog\helpers\UrlHelper;

Asset::register($this);

?>

<?php foreach($vocabularies as $vocabulary): ?>
    <?php if(isset($filterItems[$vocabulary->id])):?>
        <h2><?=$vocabulary->name;?></h2>
        <?php foreach($filterItems[$vocabulary->id] as $term): ?>
            <div data-href="<?=UrlHelper::getUrlParams($vocabulary, $term); ?>"><?=$term->name;?></div>
        <?php endforeach; ?>
    <?php endif;?>
<?php endforeach; ?>

<?php exit('A');?>


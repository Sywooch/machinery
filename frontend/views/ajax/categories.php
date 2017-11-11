<?php
use yii\helpers\Json;
use frontend\helpers\CatalogHelper;
$out = '';
?>
<?php foreach ($categories as $category): ?>
    <?php if ($category->pid && $category->vid == 2){
        $out .= '<option 
        value="'.$category->id.'"
        data-value="' . 
            CatalogHelper::getRootCategory($categories, $category)->transliteration . 
            '" data-translit="'. $category->transliteration . '">'. 
            $category->name .' ('. $categoryCounts[$category->id]['c'] .
            ')</option>';

    } ?>
<?php endforeach; ?>
<?= $out; ?>


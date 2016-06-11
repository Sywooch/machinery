<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use frontend\modules\cart\Asset as CartAsset;
use frontend\modules\cart\helpers\CartHelper;
use common\modules\file\helpers\FileHelper;
use common\modules\file\helpers\StyleHelper;
use frontend\modules\product\Asset as ProductAsset;

ProductAsset::register($this);
CartAsset::register($this);

$this->title = Html::encode($product->title);
$this->params['breadcrumbs'][] = $this->title;
?>
<h2><?=Html::encode($product->title);?></h2>
<div>
    
    <ul id="imageGallery">
        <?php foreach($product->files as $file):?>
            <li data-thumb="/<?=StyleHelper::getPreviewUrl($file, '130x130');?>" data-src="<?='/'.$file->path.'/'.$file->name; ?>">
              <?php echo Html::img('/'.$file->path.'/'.$file->name); ?>
            </li>
        <?php endforeach;?>
    </ul>
</div>
<div><? echo Html::encode($product->sku);?></div>
<div><?php echo \Yii::$app->formatter->asCurrency($product->price); ?></div>
<div><?php echo CartHelper::getBuyButton($product);?></div>
<div class="body">
        <?=
        HtmlPurifier::process($product->description, [
            'HTML.AllowedElements' => ['p', 'br', 'b', 'ul', 'li'],
            'AutoFormat.AutoParagraph' => true
        ]);
        ?>
    </div>
<?=CartHelper::getConfirmModal();?> 
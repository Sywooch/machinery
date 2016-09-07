<?php

use frontend\modules\comments\Asset;
use yii\widgets\LinkPager;

Asset::register($this); 
?>

<div class="comments-list">
	<a name="comments"></a>
	<?php if (empty($dataProvider->getModels())): ?>
            'Здесь пока никто ничего не писал.'
        <?php else:?> 
            <?php foreach($comments as $comment):?>
            <?=$this->render('_list', [
                    'comment' => $comment, 
                    'model' => $model,
                    'maxThread' => $maxThread
                ]); ?>
            <?php endforeach;?>
        <?php endif;?>
</div>

<?=LinkPager::widget(['pagination' => $dataProvider->pagination]); ?>

<?=$this->render('_form', [
        'model' => $model, 
        'avatar' => $avatar
    ]); ?>






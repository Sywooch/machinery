<?php

use yii\bootstrap\Html;
use yii2mod\bxslider\BxSlider;
use yii\helpers\ArrayHelper;


?>

<div class="actions">
    
<h3>
     <a href="/actions">Акции</a>
</h3>

<?php foreach(ArrayHelper::getColumn($actions, 'image.0') as $index => $file): ?>
<div class="action-item">
<?= Html::a(Html::img('/'.$file->path.'/'.$file->name),[$actions[$index]->url->alias]);?>
<?= Html::a(Html::encode($actions[$index]->title),[$actions[$index]->url->alias],['class' => 'title']);?>
    </div>
<?php endforeach; ?>
</div>



<?php

use yii\bootstrap\Html;
use yii2mod\bxslider\BxSlider;
use yii\helpers\ArrayHelper;
use yii\helpers\HtmlPurifier;

?>

<div class="reviews">
    
<h3>
     <a href="/review">Обзоры</a>
</h3>

    <div class="row">
            <?php foreach($reviews as $review): ?>
            <div class="col-lg-3 col-md-3 col-sm-4 review-item">
                <div class="date"><?=Yii::$app->formatter->asDate($review->created_at, 'php:d F');?></div>
                <?= Html::a(Html::encode($review->title),[$review->url->alias],['class' => 'title']);?>
                <div class="body"><?= HtmlPurifier::process($review->short, [
                        'HTML.AllowedElements' => [],
                        'AutoFormat.AutoParagraph' => false
                    ]);
                ?>
                </div>
            </div>
            <?php endforeach; ?>
    </div>
</div>
    



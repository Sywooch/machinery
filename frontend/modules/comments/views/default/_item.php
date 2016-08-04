<?php

use yii\helpers\Html;
use frontend\modules\comments\helpers\CommentsHelper;
?>
<div>
    <?=$this->render('../../widgets/views/_list', [
                    'comment' => $comment, 
                    'model' => $model
                ]); ?>
</div>

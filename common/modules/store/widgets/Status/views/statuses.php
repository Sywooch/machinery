<?php

use yii\helpers\Html;
?>
<div  id="statuses">


    <ul class="list-group">
        <li class="list-group-item box-header">Статусы</li>
        <?php foreach ($models as $model): ?>
            <li class="list-group-item">

                <div class="pull-left username">
                    <?php if ($model->user): ?>
                        <?=Html::a($model->user->username, ['/user/profile/show', 'id' => $model->user->id]);?>
                    <?php else:?>
                        Anonim
                    <?php endif; ?>
                </div>

                <div class="pull-left comments">
                    <span>Комментарий: </span> <?= Html::encode($model->comment); ?>
                </div>



                <div class="pull-right time">
                    <span class="glyphicon glyphicon-time"></span>
                    <?= Yii::$app->formatter->asTime($model->updated_at, 'short'); ?>
                </div>

                <div class="pull-right status">
                    <div><?= $statuses[$model->to] ?></div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
    <?= $this->render('_form', [
            'statuses' => $statuses,
            'statusModel' => $statusModel
        ]);
    ?>
</div>

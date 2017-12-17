<?php
use yii\widgets\ActiveForm;

common\modules\communion\Asset::register($this);
?>

<div class="modal fade" id="communityModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="icon ic-close">&times;</span>
                </button>
                <h4 class="modal-title" id="exampleModalLabel"><?= Yii::t('app', 'New message' ) ?></h4>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin([
                    'action' => \yii\helpers\Url::to(['communion/message/create']),
                    'options' => ['id' => 'message-form', 'class' => 'ajax-message-form'],
                ]);
                ?>

                <?php if(Yii::$app->user->isGuest): ?>
                    <?= $form->field($model, 'contacts')->textInput(); ?>
                <?php endif; ?>
                <?= $form->field($communion, 'subject')->hiddenInput(['value'=>$subject])->label(''); ?>

                <?= $form->field($communion, 'user_to')->hiddenInput(['value'=>$user_to])->label(''); ?>

                <?= $form->field($model, 'body')->textarea() ?>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Send message</button>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php

use yii\helpers\Html;
use dektrium\user\helpers\Timezone;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


$this->title = Yii::t('user', 'Profile settings');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="row">
        <div class="col-md-3  sidebar sidebar-account">
            <?= $this->render('../profile/_photo', ['profile' => $model]) ?>
            <?= $this->render('../profile/_menu') ?>
        </div>
        <div class="col-md-9">
            <div class="account-container">
                <?= $this->render('../profile/_head') ?>
                <?php $form = ActiveForm::begin([
                    'id' => 'profile-form',
                    'options' => ['class' => ''],
                    'fieldConfig' => [
                        'template' => "{label}\n{input}\n{error}\n{hint}",
                        'labelOptions' => ['class' => 'control-label'],
                    ],
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                    'validateOnBlur' => false,
                ]); ?>
                <div class="cf">
                    <div class="col-md-6"><?= $form->field($model, 'name') ?></div>
                    <div class="col-md-6"><?= $form->field($model, 'last_name') ?></div>
                </div>
                <div class="cf">
                    <div class="col-md-6"><?= $form->field($model, 'website') ?></div>
                    <div class="col-md-6"><?= $form->field($model, 'phone') ?></div>
                </div>
                <div class="cf">
                    <div class="col-md-6">
                        <?= $form->field($model, 'location')->dropDownList([]) ?>
                    </div>
                </div>
                <div class="cf">
                    <div class="col-md-12">
                        <?= $form->field($model, 'bio', ['template' => '{label}{input}{error}'])->textarea(['placeholder' => Yii::t('user', 'Im someting write here....This is active input')]) ?>
                    </div>
                </div>
                <div class="social-inputs">

                    <h2 class="h2 text-uppercase"><?= Yii::t('user', 'Social media'); ?>:</h2>

                    <?= $form->field($model, 'social[facebook]', ['template' => '{label}<div class="input-wrap inline-input"><i class="soc-ic ic-fb"></i>{input}</div>{error}'])->label('Facebook:', ['class' =>'lbl']) ?>
                    <?= $form->field($model, 'social[twitter]', ['template' => '{label}<div class="input-wrap inline-input"><i class="soc-ic ic-tw"></i>{input}</div>{error}'])->label('Twitter:', ['class' =>'lbl']) ?>
                    <?= $form->field($model, 'social[linkedin]', ['template' => '{label}<div class="input-wrap inline-input"><i class="soc-ic ic-in"></i>{input}</div>{error}'])->label('Linkedin:', ['class' =>'lbl']) ?>
                    <?= $form->field($model, 'social[skype]', ['template' => '{label}<div class="input-wrap inline-input"><i class="soc-ic ic-skype"></i>{input}</div>{error}'])->label('Skype:', ['class' =>'lbl']) ?>

                </div>
                <div class="form-group action-profile">
                    <div class="">
                        <?= Html::submitButton(Yii::t('user', 'Save changes'), ['class' => 'btn btn-lg btn-warning']) ?>
                        <br>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

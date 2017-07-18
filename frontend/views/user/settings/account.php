<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;


$this->title = Yii::t('user', 'Account settings');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="row">
        <div class="col-md-3 sidebar sidebar-account">
            <?= $this->render('../profile/_photo', ['profile' => $model->user->profile]) ?>
            <?= $this->render('../profile/_menu') ?>
        </div>
        <div class="col-md-9">
            <div class="account-container">
            <?= $this->render('../profile/_head') ?>
            <?php $form = ActiveForm::begin([
                'id' => 'account-form',
                'options' => ['class' => 'form-horizontal'],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-sm-offset-3 col-lg-9\">{error}\n{hint}</div>",
                    'labelOptions' => ['class' => 'col-lg-3 control-label'],
                ],
                'enableAjaxValidation' => true,
                'enableClientValidation' => false,
            ]); ?>

            <?= $form->field($model, 'email') ?>

            <?= $form->field($model, 'new_password')->passwordInput() ?>

            <?= $form->field($model, 'password_repeat')->passwordInput() ?>

            <hr/>

            <?= $form->field($model, 'current_password')->passwordInput() ?>

            <div class="form-group">
                <div class="col-lg-offset-3 col-lg-9">
                    <?= Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-block btn-success']) ?><br>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
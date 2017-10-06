<?php

use vova07\imperavi\Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Pages */
/* @var $form yii\widgets\ActiveForm */

$translatesArray = ArrayHelper::map($translates, 'id', 'lang');
$translatesKeys  = ArrayHelper::map($translates, 'lang', 'id');
//dd($translatesKeys);
?>

<div class="pages-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'lang',
                [
                    'options' => [
                        'template' => '{label}{input}',
                    ]])->dropDownList(ArrayHelper::map($languages, 'url', 'name')) ?>
        </div>
        <div class="col-md-6">
            <?php if ($model->lang): ?>
                <label for=""><?= Yii::t('app', 'Translate') ?></label>
                <div>
                    <?php foreach ($languages as $lang): ?>
                        <?php if ($model->lang !== $lang->url): ?>
                            <?php if (!in_array($lang->url, $translatesArray)): ?>
                                <a href="<?= \yii\helpers\Url::to(['pages/create', 'parent' => $model->id, 'lang' => $lang->url]) ?>"
                                   class="btn btn-primary"><?= $lang->name ?></a>
                            <?php else: ?>
                                <a href="<?= \yii\helpers\Url::to(['pages/update', 'id' => $translatesKeys[$lang->url]]) ?>"
                                   class="btn btn-primary"><?= $lang->name ?></a>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>

            <?php endif; ?>
        </div>
    </div>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <!--    --><? //= $form->field($model, 'test')->dropDownList(\yii\helpers\ArrayHelper::map($terms1,'id','name'),[ 'prompt'=>'- Select -']) ?>
    <!--    --><? //= $form->field($model, 'test2')->dropDownList(\yii\helpers\ArrayHelper::map($terms2,'id','name'),[ 'prompt'=>'- Select -', 'multiple' => 'multiple']) ?>
    <?= $form->field($model, 'parent')->hiddenInput()->label(false); ?>
    <?= $form->field($model, 'body')->widget(Widget::className(), [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 600,
            'plugins' => [
                'clips',
                'fullscreen'
            ]
        ]
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

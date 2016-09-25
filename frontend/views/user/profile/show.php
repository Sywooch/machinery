<?php

use yii\helpers\Html;
use common\modules\file\helpers\StyleHelper;
use yii\helpers\ArrayHelper;
use kartik\editable\Editable;
use kartik\file\FileInput;
use common\modules\file\helpers\FileHelper;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use frontend\modules\cart\Asset as CartAsset;

CartAsset::register($this);

$this->title = empty($profile->name) ? Html::encode($profile->user->username) : Html::encode($profile->name);
$this->params['breadcrumbs'][] = $this->title;
?>
<h1>Личный кабинет</h1>
<div class="row">
    <div class="col-lg-12  ">
        <div class="profile-img">
        <?php if(($file = ArrayHelper::getValue($profile->user->avatar, '0'))):?>
            <?=Html::img('/'.StyleHelper::getPreviewUrl($file, '145x175'),['class' => 'img-responsive']);?>
        <?php else:?>
            <?=Html::img('/files/nophoto_145x175.jpg',['class' => 'img-responsive']);?>
        <?php endif;?>
            
        <?php if(Yii::$app->user->id == $profile->user_id):?>
           
            
            <?php
            Modal::begin([
              
                'toggleButton' => ['label' => 'Загрузить фотографию','class' => 'btn btn-green btn-custom'],
            ]);
            ?>
            <?php $form = ActiveForm::begin([
                        'options' => ['enctype' => 'multipart/form-data'],
            ]); ?>
            <?= $form->field($profile->user, 'avatar[]', ['template' => '{input}{error}'])->widget(FileInput::classname(),FileHelper::FileInputConfig($profile->user, 'avatar', [
                'style' => new StyleHelper('145x175')
            ])); ?>
            <?php ActiveForm::end(); ?>
            <?php Modal::end();?>
           
            
        <?php endif;?>    
        </div>
        <div class="profile-info">
            <div class="form-group required">
                <label>ФИО</label>
                <?php if(Yii::$app->user->id == $profile->user_id):?>
                <?= Editable::widget([
                        'model'=> $profile,
                        'attribute' => 'name',
                        'asPopover' => true,
                        'size' => 'md',
                        'displayValue' => $profile->name

                    ]);
                ?>
                <?php else: ?>
                <?=$profile->name;?>
                <?php endif; ?>
            </div>
            
            <div class="form-group required">
                <label>E-mail</label>
                <?php if(Yii::$app->user->id == $profile->user_id):?>
                <?= Editable::widget([
                        'model'=> $profile->user,
                        'attribute' => 'email',
                        'asPopover' => true,
                        'size'=>'md',
                        'displayValue' => $profile->user->email

                    ]);
                ?>
                <?php else: ?>
                <?=$profile->user->email;?>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label>Телефон</label>
                <?php if(Yii::$app->user->id == $profile->user_id):?>
                <?= Editable::widget([
                        'model'=> $profile,
                        'attribute' => 'phone',
                        'asPopover' => true,
                        'size'=>'md',
                        'inputType' => Editable::INPUT_WIDGET,
                        'widgetClass' => 'yii\widgets\MaskedInput',
                        'options' => [
                            'mask' => '+38 (099)-999-99-99',
                        ],
                        'displayValue' => $profile->phone

                    ]);
                ?>
                <?php else: ?>
                <?=$profile->phone;?>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label>Дата рождения</label>
                <?php if(Yii::$app->user->id == $profile->user_id):?>
                <?= Editable::widget([
                        'model'=> $profile,
                        'attribute' => 'birth',
                        'asPopover' => true,
                        'size'=>'md',
                        'inputType' => Editable::INPUT_WIDGET,
                        'widgetClass' => 'yii\widgets\MaskedInput',
                        'options' => [
                            'mask' => '99.99.9999',
                        ],
                        'displayValue' => $profile->birth

                    ]);
                ?>
                <?php else: ?>
                <?=$profile->birth;?>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label>Аккаунт создан</label>
                <?=date('d.m.Y',$profile->user->created_at);?>
            </div>
            
        </div>
    </div>   
</div>

<h2>Мои заказы</h2>
<div class="my-orders ">
<?php foreach($orders as $order):?>
<div class="row header">
    <div class="col-lg-2">
       №<?=$order->id?>
    </div>
    <div class="col-lg-6">
       <?=Yii::$app->formatter->asDate($order->created, 'd MMMM yyyy');?>
    </div>
    <div class="col-lg-4">
        <?=Html::a('Печатная версия',['/orders/default/print', 'id' => $order->id],['target' => '_blank','class' => 'pull-right'])?>
    </div>
</div>
<?=$this->render('../../../modules/cart/views/default/_items',['order' => $order]);?>
<?php endforeach;?>
</div>
<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use kartik\checkbox\CheckboxX;

$this->title = Html::encode('Список желаний');
$this->params['breadcrumbs'][] = ['label' => $user->profile->name ? $user->profile->name : $user->username, 'url' => '/user/'.$user->id];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]) ?>
<h1><?=$this->title;?></h1>
<?= $this->render('../../../../views/user/profile/_tabs',['id' => $user->id, 'action' => 'wish']);?>


 <?php $form = ActiveForm::begin([
            'id' => 'wish-form',

        ]); ?>
        
<div class="header-table-list" data-url="/catalog/wish/remove">
            <div class="row  ">
                <div class="col-lg-6 col-md-6 col-sm-6"  id="chb-all-conteiner">
                    <?=CheckboxX::widget([
                        'name'=>'chb_all',
                        'options'=>['id' => 'chb_all'],
                        'pluginOptions' => ['size'=>'xs', 'threeState' => false]
                    ]);?>
                    <span id="multi-text"></span>
                     <?= Html::a('Удалить выбранное', ['#'], ['class' => 'btn btn-default ', 'id' => 'multi-delete-button']); ?>
                </div>
            </div>
        </div>

<?= $this->render('_items',['models' => $models,'wishList' => $wishList]);?>
    
<?php ActiveForm::end(); ?>
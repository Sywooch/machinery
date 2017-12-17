<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CurrencySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Currencies');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="currency-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Currency'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'code',
            'course',
//            'default:boolean',
            [
                'label' => Yii::t('app', 'Default'),
                'format' => 'raw',
                'value' => function ($model) {
                    $checked = $model->default ? 'checked' : '';
                    return "<input type=\"radio\" name=\"default_cur\" value='".$model->id."' class='radio_default_cur' $checked >";
                }
            ],
            // 'active:boolean',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?></div>
<?= $this->registerJs("

    $(function(){
        var urlDefaultChange = '". \yii\helpers\Url::to(['currency/default']) ."';

        $('.radio_default_cur').on('change', function(e){
            var input = this;
            $.get(urlDefaultChange, {id: input.value}, function(d){

            }, 'json');
        });
    })") ?>
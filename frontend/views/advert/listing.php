<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;

$this->title = Yii::t('app', 'My offers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="row">
        <div class="col-md-3 sidebar sidebar-account">
            <?= $this->render('/user/profile/_photo', ['profile' => $profile]) ?>
            <?= $this->render('/user/profile/_menu') ?>
        </div>
        <div class="col-md-9">
            <div class="account-container">
                <?= $this->render('/user/profile/_head') ?>

                <div class="list-offers _list cf">
                    <?php Pjax::begin(); ?>    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
//                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            'id',
                            'title',
                            [
                                'label' => Yii::t('app', 'Description'),
                                'value' => function($model){
                                    return substr($model->body, 0, 20).'...';
                                }
                            ],
                            'price',
//                            'currency',
                            [
                                'label' => Yii::t('app', 'currency'),
                                'value' => function($model){
                                    return \common\models\Currency::findOne($model->currency)->name;
                                }
                            ],
                            [
                                'label' => Yii::t('app', 'Author'),
                                'value' => function($model){
                                    return \common\models\User::findOne($model->user_id)->username;
                                }
                            ],
//                            [
//                                'label' =>  Yii::t('app', 'Status'),
//                                'value' => function($model){
//                                    return $model->status == 1 ? Yii::t('app', 'Active') : Yii::t('app', 'Disabled');
//                                }
//                            ],
//                            [
//                                'label' =>  Yii::t('app', 'created'),
//                                'value' => function($model){
//                                    return Yii::$app->formatter->asDate($model->created, 'd-M-Y');
//                                }
//                            ], [
//                                'label' =>  Yii::t('app', 'Published'),
//                                'value' => function($model){
//                                    return Yii::$app->formatter->asDate($model->published, 'd-M-Y');
//                                }
//                            ],
                            // 'website',
                            // 'manufacture',
                            // 'phone',
                            // 'model',
                            // 'year',
                            // 'condition',
                            // 'operating_hours',
                            // 'mileage',
                            // 'bucket_capacity:ntext',
                            // 'tire_condition::ntext',
                            // 'serial_number:ntext',
                             'created:date',
                            // 'updated',
                             'published:date',
//                             'status:boolean',
                            // 'maderated:boolean',

                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]); ?>
                    <?php Pjax::end(); ?>
                </div> <!-- .list-favorite-adv -->

            </div>
        </div>
    </div>
</div>
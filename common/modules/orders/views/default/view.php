<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use common\modules\orders\widgets\Status\Asset;

Asset::register($this);

$this->title = "Заказ №" . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Cart Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cart-orders-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if ($model->status) echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php
        if ($model->status)
            Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-default',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ])
            ?>
    </p>


    <?php
    $un = '';

    if ($model->user_id) {
        if ($model->name)
            $un = Html::a($model->name, ['/user/profile/show', 'id' => $model->user->id]);
        else
            $un = Html::a($model->user->username, ['/user/profile/show', 'id' => $model->user->id]);
    }else {
        if ($model->name)
            $un = $model->name;
        else
            $un = 'Аноним';
    }
    ?>
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => 'Пользователь',
                'value' => $un,
                'format' => 'html',
            ],
            'email:email',
            'phone',
            'comment:ntext',
            'ordered:datetime',
            'price:currency',
            [
                'label' => 'Статус',
                'value' => $model->statuses[$model->status]
            ],
        ],
    ])
    ?>



    <div class="panel panel-default">
        <div class="panel-heading">Products</div>
        <table class="table cart-table">
            <tr>
                <th>#</th>
                <th>Код</th>
                <th>Продукт</th>
                <th>Цена</th>
                <th></th>
                <th>Количество</th>
                <th>Сумма</th>

            </tr>
            <?php foreach ($model->items as $key => $item): ?>
                <tr>
                    <td>
                        <?= $item->entity_id; ?>
                    </td>
                    <td>
                        <?=$item->sku; ?>
                    </td>
                    <td style="width:50%;"><a href="/admin/product-default/view?id=<?= $item->entity_id ?>" ><?= Html::encode($item->title); ?></a></td>
                    <td><?= Yii::$app->formatter->asCurrency($item->price); ?></td>
                    <td>x</td>
                    <td style="width: 150px;">
                        <div class="input-group input-group-sm">
                            <?= $item->count; ?>
                        </div>
                    </td>
                    <td>
                        <span class="price"><?= Yii::$app->formatter->asCurrency($item->price * $item->count); ?></span>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php foreach ($model->promo as $key => $item): ?>
                <tr>
                    <td>
                        <?= $item->entity_id; ?>
                    </td>
                    <td>
                        <?=$item->sku; ?>
                    </td>
                    <td style="width:50%;"><a href="/admin/product/promo-codes/view?id=<?= $item->entity_id ?>" ><?= Html::encode($item->title); ?></a></td>
                    <td>-<?= Yii::$app->formatter->asCurrency($item->price); ?></td>
                    <td></td>
                    <td style="width: 150px;">
                        <div class="input-group input-group-sm">
                          
                        </div>
                    </td>
                    <td>
                        <span class="price"></span>
                    </td>
                </tr>
            <?php endforeach; ?>    
        </table>
    </div>

    <?= common\modules\orders\widgets\Status\StatusWidget::widget([
            'model' => $model
        ]);
    ?>


</div>

<?php

use yii\helpers\Html;

$this->beginBlock('title_panel');
echo 'Admin panel';
$this->endBlock();

$this->title = Yii::t('app', 'My Tariff plan');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container">
    <div class="row">
        <div class="col-md-3 sidebar sidebar-account">
            <?= $this->render('_photo', ['profile' => $profile]) ?>
            <?= $this->render('_menu') ?>
        </div>
        <div class="col-md-9">
            <div class="account-container">
                <?= $this->render('_head') ?>
                <?php //dd($model) ?>
                <table class="tbl list-tarif table table-hover">
                    <thead>
                    <tr>
                        <th><?= Yii::t('app', 'Title') ?></th>
                        <th><?= Yii::t('app', 'Date create') ?></th>
                        <th><?= Yii::t('app', 'Date pay') ?></th>
                        <th><?= Yii::t('app', 'Date end') ?></th>
                        <th><?= Yii::t('app', 'Active') ?></th>
                        <th><?= Yii::t('app', 'Options') ?></th>
                        <th><?= Yii::t('app', 'Total adverts') ?></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($model as $item): ?>
                        <tr>
                            <td><?= $item->package->name ?></td>
                            <td><?= Yii::$app->formatter->asDate($item->create_at) ?></td>
                            <td><?= Yii::$app->formatter->asDate($item->date_pay) ?></td>
                            <td><?= Yii::$app->formatter->asRelativeTime($item->deadline) ?></td>
                            <td><?= Yii::$app->formatter->asBoolean($item->status) ?></td>
                            <td>
                                <?php if($item->options):
                                    echo json_encode($item->options); ?>
<!--                                --><?php //foreach ($item->options as $opt): ?>
<!--                                    <div>--><?//= $opt->name ?><!--</div>-->
<!--                                --><?php //endforeach; ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>

                </table> <!-- .list-favorite-adv -->

            </div>
        </div>
    </div>
</div>
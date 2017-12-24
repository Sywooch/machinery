<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <?php //dd($messages) ?>
            <div class="col-lg-6">
                <div class="box">
                    <div class="box-body">
                        <h2>New Messages</h2>
                        <table class="table table-condensed">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if ($messages): foreach ($messages as $k => $message): ?>
                                <tr>
                                    <td><?= $k + 1 ?></td>
                                    <td><?= $message->id ?></td>
                                    <td><strong><?= $message->comunion->subject ?></strong></td>
                                    <td><?= \yii\helpers\StringHelper::truncate($message->body, 50) ?></td>
                                    <td><?= Yii::$app->formatter->asDatetime($message->create_at, 'short') ?></td>
                                    <td>
                                        <a href="<?= \yii\helpers\Url::to(['/communions/view', 'id' => $message->comunion->id]) ?>"
                                           class="btn btn-xs btn-success"><span
                                                    class="glyphicon glyphicon-eye-open"></span></a>
                                        <a href="<?= \yii\helpers\Url::to(['/message/delete', 'id' => $message->id]) ?>"
                                           data-pjax="0" data-confirm="Are you sure you want to delete this item?"
                                           data-method="post" class="btn  btn-xs btn-danger delete-message"><span
                                                    class="glyphicon glyphicon-trash"></span></a>
                                    </td>
                                </tr>
                            <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                        <p><a class="btn btn-default" href="<?= \yii\helpers\Url::to(['communions/support']) ?>">All support messages &raquo;</a>
                        </p>

                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="box">
                    <div class="box-body">
                        <h2>New Adverts</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="box">
                    <div class="box-body">
                        <h2>New Users</h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="box">
                    <div class="box-body">
                        <h2>New Comments</h2>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

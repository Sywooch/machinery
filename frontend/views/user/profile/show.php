<?php

use yii\helpers\Html;

$this->title = empty($profile->name) ? Html::encode($profile->user->username) : Html::encode($profile->name);
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-3">
        <?= $this->render('_photo', ['profile' => $profile]) ?>
        <?= $this->render('_menu') ?>
    </div>
    <div class="col-md-9">
        <?= $this->render('_head') ?>

        <div>

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#resent" data-toggle="tab">Recently viewed</a>
                </li>
                <li role="presentation">
                    <a href="#favorite" data-toggle="tab">My favorite listing</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="resent">
                    <a href="#">fgdfgfdg35 235 235</a>
                    <a href="#">fgdfgfdg35 235 235</a>
                </div>
                <div class="tab-pane" id="favorite">
                    <a href="#">222</a>
                    <a href="#">22</a>
                </div>
            </div>

        </div>


    </div>
</div>
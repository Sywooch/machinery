<?php

use yii\helpers\Html;
$this->beginBlock('title_panel');
echo 'Admin panel';
$this->endBlock();

$this->title = Yii::t('app', 'My favorite');
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

                <div class="list-offers _list flexbox cf">
                    <?php for($i=0; $i<3; $i++): ?>
                    <?php echo $this->render('/parts/item-offer'); ?>
                    <?php endfor; ?>

                </div> <!-- .list-favorite-adv -->

            </div>
        </div>
    </div>
</div>
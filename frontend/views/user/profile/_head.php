<?php
use common\modules\communion\models\CommunionMessage;
//dd(CommunionMessage::findNewMessage());
?>

<ul class="account-menu-tab flexbox just-between">
    <li class="item-menu item-menu-1 _has-title col-sm-6"><span class="_title .h1"><?= $this->title ?></span></li>
    <li class="item-menu item-menu-2 _has-link col-sm-2"><a href="<?= \yii\helpers\Url::to(['profile/communion']) ?>"><span><span class="_count"><?= count(CommunionMessage::findNewMessage()) ?></span><span class="_text"><?= Yii::t('app', 'New messages') ?></span></span></a></li>
    <li class="item-menu item-menu-3 _has-link col-sm-2"><a href="#"><span><span class="_count">54</span><span class="_text">Listing created</span></span></a></li>
    <li class="item-menu item-menu-4 _has-link col-sm-2"><a href="#"><span><span class="_count">2</span><span class="_text">Orders made</span></span></a></li>
</ul>

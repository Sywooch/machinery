<?php
use backend\widgets\UserBlock\UserBlock;
use backend\widgets\AdminMenu\MainMenu;
?>
<section class="sidebar">
    <!-- Sidebar user panel -->
    <?= UserBlock::widget(); ?>
    <?= MainMenu::widget(); ?>
    
</section>
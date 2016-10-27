<?php

?>

<div class="btn-group custom tabs-profile" role="group" >
    <a class="btn btn-default <?= $action == 'profile' ? 'active' : '';?>"  href="/user/<?=$id?>">Профиль</a>
    <a class="btn btn-default <?= $action == 'wish' ? 'active' : '';?>" href="/user/<?=$id?>/wish">Список желаний</a>
</div>
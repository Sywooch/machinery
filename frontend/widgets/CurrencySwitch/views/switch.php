<?php
/**
 *
 */
?>
<li class="dropdown">
    <select name="currency" id="currency-switcher" class="currency-switcher">
        <?php foreach ($model as $key => $val): ?>
            <option value="<?= $val['code'] ?>" <?= $activeCurrency == $val['code'] ? 'selected' : '' ?>"><?= $val['name'] ?></option>
        <?php endforeach; ?>

    </select>
</li>

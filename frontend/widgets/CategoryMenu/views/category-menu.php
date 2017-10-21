<?php
/**
 *
 */
$request = Yii::$app->request;
$slug = $request->get('slug') ?? null;
$cat_id = $_GET['FilterForm']['category'] ?? null;

?>
<ul class="list-categories">
    <?php if($categories): foreach ($categories as $item): ?>
        <?php
        $titles = $item->data['translations'];
        $title = (isset($titles[Yii::$app->language]) && $titles[Yii::$app->language]) ? $titles[Yii::$app->language] : $item->name;
        _?>
        <li>
            <a href="<?= \yii\helpers\Url::to(['catalog/index', 'slug'=>$item->transliteration]) ?>" class="item-menu-cat<?= ($slug == $item->transliteration || $cat_id == $item->id) ? ' active' : '' ?>">
                <i class="ic-cat ic-cat-<?= $item->icon_name; ?>"></i>
                <span><?= $title; ?></span>
            </a>
        </li>
    <?php endforeach; endif; ?>

</ul>

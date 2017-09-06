<?php

use yii\helpers\Html;

$cookies = Yii::$app->request->cookies;

$this->title = Yii::t('app', 'Production') . ' <span class="white">' . Yii::t('app', 'Catalog') . '</span> / ' . 'Industrial machinery';
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Catalog'),
    'url' => 'catalog'
];
$this->params['breadcrumbs'][] = 'Industrial machinery';
?>
<div class="container main-container">
    <div class="row">
        <div class="col-md-3 sidebar sidebar-inner">
            <?= \frontend\widgets\Packages\PackagesWidget::widget() ?>
        </div>
        <div class="col-md-9">
            <div class="advert-container">
                <div class="form-wrapper">
                    <?= $this->render('_form', [
                        'model' => $model,
                        'languages' => $languages,
                        'categories' => $categories,
//                        'manufacturer' => $manufacturer,
                            ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
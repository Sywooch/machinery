<?php
/**
 * @var model         Все пакеты
 * @var advert        Объявление если на редактировании
 * @var options       Все опции
 * @var package       Активный (заказанный, но может быть не оплаченный) заказ пакета
 *
 */

use yii\helpers\ArrayHelper;
use yii\web\View;

echo $advert->id;

?>

<div class="block-sidebar block-sidebar-packages block-sidebar-bg block-bg-texture">
    <div class="btn-filter-open-wrap">
        <a href="#" type="button" class="open-filter btn-open-filter btn">
            <i class="ic-arr-orange-button"></i></a>
    </div>
    <div class="h2 block-title"><?= Yii::t('app', 'Select your package:') ?></div>
    <div class="block-content">
        <form>
            <div class="list-packages">
                <?php if ($model): foreach ($model as $item): ?>
                    <div class="package-item flexbox just-between">
                        <input type="radio"
                               id="pack-<?= $item->id ?>"
                               name="package"
                               class="package_radio <?= ($item->id == $package['package_id']) ? 'in_order_active' : '' ?>"
                               autocomplete="off"
                               value="<?= $item->id ?>"
                               <?= ($item->id == $package['package_id']) ? 'checked' : '' ?>
                               data-cost="<?= $item->price ?>"
                        >
                        <label for="pack-<?= $item->id ?>" class="flexbox just-between dropdown">
                            <span class="_price flexbox"><span class="align-auto"><?= number_format($item->price, 0) ?>
                                    <span class="currency-package">$</span></span></span>
                            <span class="_title-block">
                                <span class="_title"><?= $item->name; ?></span>
                                <?php if ($item->sub_caption): ?>
                                    <span class="_subtitle"><?= $item->sub_caption ?></span>
                                <?php endif; ?>
                            </span>
                        </label>
                        <?php $item->customOptions = $item->arrayOptions($item->optionsPack); ?>
                        <div class="info-block btn-hover-hint">
                            <div class="info-btn-bg">
                                <div class="info-btn"><i class="fa fa-info" aria-hidden="true"></i></div>
                            </div>
                            <div class="package-description-block package-drop">
                                <div class="info-inner">
                                    <div class="h2"><?= $item->name; ?></div>
                                    <p><?= $item->description ?></p>
                                    <div class="h3"><?= number_format($item->price, 2) ?><span class="currency-package">$</span>
                                        for a <?= $item->term ?> day listing.
                                    </div>
                                    <ul class="list-options-package">
                                        <?php foreach ($options as $opt): ?>
                                            <li class="<?= in_array($opt->id, $item->customOptions) ? 'active' : 'disabled' ?>"><i
                                                        class="fa fa-check-circle"
                                                        aria-hidden="true"></i><span><?= $opt->name ?></span>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> <!-- .package-item -->
                <?php endforeach; endif; ?>
            </div>
        </form>
    </div>
</div>

<?php
/**
 * Options
 */
?>
<div class="block-sidebar block-list-enhancements block-bg-color block-sidebar-bg">
    <div class="h2 title-block grey-ttl  text-uppercase"><?= Yii::t('app', 'Listing Enhancements:') ?></div>
    <div class="block-content">
        <div class="_text"><?= Yii::t('app', 'Enhance your listing with any of the additional features below;') ?></div>
        <div class="list-enhancements">
            <?php foreach ($options as $option): ?>
                <div class="item-enhancement">
                    <div class="inner-item-enhancement flexbox">
                        <input type="checkbox" name="enhancement[]" class="enhancement-checkbox"
                               id="enhancement-<?= $option->id ?>" value="<?= $option->id ?>"
                               data-cost="<?= number_format($option->price, 0) ?>" autocomplete="off"
                               data-inpack="<?= Yii::t('app', 'In package') ?>"
                        >
                        <label class="label" for="enhancement-<?= $option->id ?>">
                            <span class="_price"><span class="currency-option"><span
                                            class="currency"> $</span></span> <?= number_format($option->price, 0) ?></span>
                            <span class="span _name"><?= $option->name ?></span>
                        </label>
                        <div class="info-block btn-hover-hint">
                            <div class="info-btn-bg ">
                                <div class="info-btn"><i class="fa fa-info" aria-hidden="true"></i></div>
                            </div>
                            <div class="package-description-block package-drop">
                                <div class="info-inner">
                                    <div class="h2"><?= $option->name ?></div>
                                    <p><?= $option->description ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="hidden-button-options text-center">
            <button id="option-advert-update" class="btn btn-warning"><span id="cost-options-advert">0</span><span
                        class="currency">$</span> <?= Yii::t('app', 'Update') ?></button>
        </div>
    </div>
</div>
<div class="block-sidebar block-total-pay block-bg-color block-sidebar-bg">
    <div class="h2 title-block grey-ttl text-uppercase"><?= Yii::t('app', 'Total payment') ?></div>
    <div class="block-content text-center">
        <div class="_text text-uppercase"><b>$20</b> for a <b id="current-termin-package">30</b> day listing;</div>
        <a href="#" class="btn btn-warning btn-pay"><?= Yii::t('app', 'Pay') ?> <i
                    class="fa fa-chevron-right" aria-hidden="true"></i></a>
    </div>
</div>

    <?php
// все полученные пакеты
$this->registerJs(
    "var packs = " . json_encode($model) . ";
    //console.log(packs); ",
        View::POS_END
) ?>
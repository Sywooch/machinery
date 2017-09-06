<?php
/**
 * @var model
 */
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
                        <input type="radio" id="pack-<?= $item->id ?>" name="package" value="<?= $item->id ?>">
                        <label for="pack-1" class=" flexbox just-between dropdown">
                            <span class="_price flexbox"><span class="align-auto"><?= number_format($item->price, 0) ?>
                                    <span class="currency-package">$</span></span></span>
                            <span class="_title-block">
                <span class="_title"><?= $item->name; ?></span>
                                <?php if ($item->sub_caption): ?>
                                    <span class="_subtitle"><?= $item->sub_caption ?></span>
                                <?php endif; ?>
            </span>
                        </label>
                        <?php $pack_opt = unserialize($item->options);
                        //print_r(unserialize($item->options)) ?>
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
                                            <li class="<?= in_array($opt->id, $pack_opt) ? 'active' : 'disabled' ?>"><i
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
            <?php foreach($options as $option): ?>
            <div class="item-enhancement">
                <div class="inner-item-enhancement flexbox">
                    <input type="checkbox" name="enhancement[]" id="enhancement-<?= $option->id ?>" value="<?= $option->id ?>">
                    <label class="label" for="enhancement-1">
                        <span class="_price"><span class="currency-option">$</span> <?= number_format($option->price, 0) ?></span>
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

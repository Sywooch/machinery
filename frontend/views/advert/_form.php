<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\modules\file\widgets\FileInput\FileInputWidget;
use common\models\Currency;
use kartik\select2\Select2;
use vova07\imperavi\Widget;
use common\modules\taxonomy\helpers\TaxonomyHelper;
use backend\widgets\CKEditorAdmin;

$translatesArray = ArrayHelper::map($translates, 'id', 'lang');
$translatesKeys  = ArrayHelper::map($translates, 'lang', 'id');
?>
<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data'],
]);
dd($translatesArray);
dd($translatesKeys);

?>
<?php //dd($model) ?>
<?= Yii::$app->language ?><br>
<?//= Yii::t('app', 'Cancel2') ?>
<?= $form->field($model, 'order_options')->textInput(['maxlength' => true]) ?>
    <div class="form-inner">
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <?= Yii::t('app', 'Short description') ?>
                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <div class="form-row">
                            <?= $form->field($translate, 'title')->textInput(['maxlength' => true]) ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <?php if(!$translate->lang): ?>
                                    <?= $form->field($translate, 'lang')
                                        ->dropDownList(
                                                ArrayHelper::map($languages, 'local', 'name'))
                                    ?>
    <?php else: ?>
                                        <?= $form->field($translate, 'lang')
                                            ->dropDownList(
                                                ArrayHelper::map($languages, 'local', 'name'), ['disabled'=>true])
                                        ?>
    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <?php if($model->lang): ?>
                                        <label><?= Yii::t('app', 'Translates') ?></label>
                                        <?php foreach ($languages as $lang): ?>
                                            <?php if ($translate->lang !== $lang->local): ?>
                                                <?php if (!in_array($lang->local, $translatesArray)): ?>
                                                    <a href="<?= \yii\helpers\Url::to(['advert/create', 'parent' => $model->id, 'language'=>$lang->url]) ?>"
                                                       class="btn btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i> &nbsp; <?= $lang->name ?></a>
                                                <?php else: ?>
                                                    <a href="<?= \yii\helpers\Url::to(['advert/update', 'id' => $model->id, 'language'=>$lang->url]) ?>"
                                                       class="btn btn-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> &nbsp; <?= $lang->name ?></a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
<!--                                        <a href="#" class="btn btn-primary btn-lang">En</a>-->
<!--                                        <a href="#" class="btn btn-primary btn-lang">De</a>-->
<!--                                        <a href="#" class="btn btn-primary btn-lang">Uk</a>-->
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <?php //= $form->field($model, 'body')->textarea(['rows' => 6]) ?>
<!--                            --><?//= $form->field($translate, 'body')->widget(Widget::className(), [
//                                'settings' => [
//                                    'lang' => substr(Yii::$app->language, 0, 2),
//                                    'minHeight' => 200,
//                                    'plugins' => [
//                                        'clips',
//                                        'fullscreen'
//                                    ]
//                                ]
//                            ]) ?>
                            <?= $form->field($translate, 'body')
                                ->widget(
                                    CKEditorAdmin::className(), [
                                    'options' => ['rows' => 6],
                                    'preset' => 'standart', // 'full', standart

                                ]) ?>
                            <div class="_hint-form"><?= Yii::t('app', 'Minimum of 200 characters. 200 characters remaining.') ?></div>
                        </div>
                        <div class="form-row">
                            <?= $form->field($translate, 'meta_description')->textInput(['maxlength' => true]) ?>
<!--                            <div class="form-group"><label for="">Keywords::</label>-->
<!--                                <input type="text" name="" id="" class="form-control">-->
<!--                            </div>-->
<!--                            <div class="_hint-form">Separate each keyword with a comma.</div>-->
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'category')
                                    ->widget(Select2::classname(), [
                                    'data' => TaxonomyHelper::terms3Level($categories),
                                    'options' => ['placeholder' => Yii::t('app', '- Select category -'), 'size'=>2],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'multiple' => true,
                                        'maximumInputLength' => 15,
                                        'tags' => true,
                                        'maximumSelectionLength' => 2,
                                    ],
                                    'showToggleAll' => false,
                                ]); ?>
                            </div>

<!--                            <div class="col-md-6">-->
<!--<!--                                --><?php ////= $form->field($model, 'manufacture')
////                                    ->dropDownList(\yii\helpers\ArrayHelper::map(
////                                        $manufacturer,'id','name'),
////                                        [ 'prompt'=>'- Select manufacture -']) ?>
<!--                                -->
<!--                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingTwo">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <?= Yii::t('app', 'Listing Details') ?>
                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                        </a>
                    </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body">

                        <div class="form-row">
                            <?= $form->field($model, 'price')->textInput(['maxlength' => true])->label(Yii::t('app', 'Price') . ':') ?>
                        </div>
                        <div class="form-row">
                            <?= $form->field($model, 'website')->textInput(['maxlength' => true])->label(Yii::t('app', 'Website link') . ': <span class="require">*</span>') ?>
                        </div>
                        <div class="form-row">
                            <?= $form->field($model, 'manufacture')->textInput(['maxlength' => true])->label(Yii::t('app', 'Manufacturer')) ?>
                        </div>
                        <div class="form-row">
                            <?= $form->field($model, 'phone')->textInput(['maxlength' => true])->label(Yii::t('app', 'Phone Number') . ':') ?>
                        </div>
                        <div class="form-row">
                            <?= $form->field($model, 'model')->textInput(['maxlength' => true])->label(Yii::t('app', 'Model') . ':') ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingThree">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            <?= Yii::t('app', 'Listing Attachments') ?>
                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                        </a>
                    </h4>
                </div>
                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                    <div class="panel-body">
                        <div class="image-upload-block cf">
                            <?php for($i=0;$i<5;$i++): ?>
                                <figure class="img-offer" style="background-image: url(/images/img-2.png)">
                                    <!-- <img src="/images/img-2.png" alt="">-->
                                    <a href="#" class="btn-remove-img"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
                                </figure>
                            <?php endfor; ?>
                            <div class="image-upload-btn flexbox"><i class="ic-add-image"></i><span><?= Yii::t('app', 'Add images') ?></span></div>
                        </div>
                        <p class="text-uppercase"><?= Yii::t('app', 'You can select up to 30 media files.') ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions text-right">
            <button type="submit" class="btn btn-warning"><?= Yii::t('app', 'Save listing') ?></button>
            <button type="reset" class="btn btn-default"><?= Yii::t('app', 'Cancel') ?></button>
        </div>
    </div>
<?php ActiveForm::end(); ?>
<?php //dd($model); ?>
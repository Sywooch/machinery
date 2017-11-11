<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\modules\file\widgets\FileInput\FileInputWidget;
use common\models\Currency;
use kartik\select2\Select2;
use vova07\imperavi\Widget;
use common\modules\taxonomy\helpers\TaxonomyHelper;
//use backend\widgets\CKEditorAdmin;
use dosamigos\ckeditor\CKEditor;
//use yii\jui\Tabs;

\yii\jui\JuiAsset::register($this);
\dosamigos\ckeditor\CKEditorWidgetAsset::register($this);
//\boundstate\plupload\PluploadAsset::register($this);

$translatesArray = ArrayHelper::map($translates, 'id', 'lang');
$translatesKeys = ArrayHelper::map($translates, 'lang', 'id');
?>
<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data', 'id' => 'obj-form'],
]);
//dd($translatesArray);
//dd($translatesKeys);

?>
<?php
for ($i = date('Y'); $i >= 1970; $i--) {
    $years[$i] = $i;
}
$years['-1970'] = Yii::t('app', 'Before 1970');
?>
<?php //dd($model) ?>
<?= $form->field($model, 'order_options')->textInput(['maxlength' => true]) ?>
    <div class="form-inner">
<!--        <div class="row">-->
<!--            <div class="col-md-6">-->
<!--             --><?php ////if ($model->isNewRecord || 1): ?>
<!----><?////= $form->field($translate, 'lang')
////                        ->dropDownList(
////                            ArrayHelper::map($languages, 'local', 'name'))
////                    ?>
<!----><?php ////else: ?>
<!----><?////= $form->field($translate, 'lang')
////                        ->dropDownList(
////                            ArrayHelper::map($languages, 'local', 'name'), ['disabled' => true])
////                    ?>
<!----><?php ////endif; ?>
<!--            </div>-->
<!--            <div class="col-md-6">-->
<!--                --><?php //if ($model->lang): ?>
<!--                    <label>--><?//= Yii::t('app', 'Translates') ?><!--</label>-->
<!--                    --><?php //foreach ($languages as $lang): ?>
<!--                        --><?php //if ($translate->lang !== $lang->local): ?>
<!--                            --><?php //if (!in_array($lang->local, $translatesArray)): ?>
<!--                                <a href="--><?//= \yii\helpers\Url::to(['advert/create', 'parent' => $model->id, 'language' => $lang->url]) ?><!--"-->
<!--                                   class="btn btn-primary"><i class="fa fa-plus-circle"-->
<!--                                                              aria-hidden="true"></i>-->
<!--                                    &nbsp; --><?//= $lang->name ?><!--</a>-->
<!--                            --><?php //else: ?>
<!--                                <a href="--><?//= \yii\helpers\Url::to(['advert/update', 'id' => $model->id, 'language' => $lang->url]) ?><!--"-->
<!--                                   class="btn btn-primary"><i class="fa fa-pencil-square-o"-->
<!--                                                              aria-hidden="true"></i>-->
<!--                                    &nbsp; --><?//= $lang->name ?><!--</a>-->
<!--                            --><?php //endif; ?>
<!--                        --><?php //endif; ?>
<!--                    --><?php //endforeach; ?>
<!--                --><?php //endif; ?>
<!--            </div>-->
<!--        </div>-->
        <div class="panel-group" id="accordions" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                           aria-expanded="true" aria-controls="collapseOne">
                            <?= Yii::t('app', 'Short description') ?>
                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <div id="tabs">
                            <ul>
                                <?php foreach ($languages as $key => $item): ?>
                                    <li><a href="#tabs-<?= $item->url ?>"><?= $item->name ?></a></li>
                                <?php endforeach; ?>

                            </ul>
                            <?php foreach ($languages as $key => $item): ?>
                                <div id="tabs-<?= $item->url ?>">
                                    <div class="form-group field-advertvariant-title required">
                                        <label class="control-label" for=""><?= Yii::t('app', 'Title', [], $item->local) ?></label>
                                        <input type="text" name="translate[<?= $item->local ?>][title]" value="<?= $translates[$item->local]['title'] ?>" class="form-control">
                                    </div>
                                    <div class="form-group field-advertvariant-body">
                                        <label class="control-label" for=""><?= Yii::t('app', 'Description', [], $item->local) ?></label>
                                        <textarea name="translate[<?= $item->local ?>][body]" id="translate-body-<?= $item->local ?>" class="editor" cols="30" rows="10" class="form-control"><?= $translates[$item->local]['body'] ?></textarea>
                                    </div>
                                    <div class="form-group field-advertvariant-meta">
                                        <label class="control-label" for=""><?= Yii::t('app', 'Meta Description', [], $item->local) ?></label>
                                        <textarea name="translate[<?= $item->local ?>][meta_description]" id="translate-meta-descr-<?= $item->local ?>" cols="30" rows="3" class="form-control"><?= $translates[$item->local]['meta_description'] ?></textarea>
                                    </div>
                                    </div>
                            <?php endforeach; ?>
                        </div>
<!--                        <div class="form-row">-->
<!--                            --><?//= $form->field($translate, 'title')->textInput(['maxlength' => true]) ?>
<!--                        </div>-->
<!--                        <div class="form-row">-->
<!--                            --><?//= $form->field($translate, 'body')
//                                ->widget(
//                                    CKEditor::className(), [
//                                    'options' => [
//                                        'rows' => 6,
//                                    ],
//                                    //    'enableKCFinder'=>false,
//                                    'preset' => 'custom', // 'full', standart, 'basic'
//                                    'clientOptions' => [
//                                        'toolbarGroups' =>
//                                            [
//                                                ['name' => 'undo'],
//                                                ['name' => 'basicstyles', 'groups' => ['basicstyles', 'cleanup']],
//                                                ['name' => 'colors'],
////                                            ['name' => 'links', 'groups' => ['links', 'insert']],
////                                                ['name' => 'others', 'groups' => ['others', 'about']],
//
//                                            ],
//                                        'uiColor' => '#FAFAFA',
//                                    ]
//                                ]) ?>
<!--                            <div class="_hint-form">--><?//= Yii::t('app', 'Minimum of 200 characters. 200 characters remaining.') ?><!--</div>-->
<!--                        </div>-->

<!--                        <div class="form-row">-->
<!--                            <div class="row">-->
<!--                                --><?//= $form->field($translate, 'meta_description', ['options' => ['class' => 'col-md-12']])->textarea(['maxlength' => true]) ?>
<!--                            </div>-->
<!--                        </div>-->
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingTwo">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                           href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                            <?= Yii::t('app', 'Listing Details') ?>
                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                        </a>
                    </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body">

                        <div class="form-row">
                            <div class="row">
                                <div class="col-md-6">
                                    <?= $form->field($model, 'category')
                                        ->widget(Select2::classname(), [
                                            'data' => TaxonomyHelper::terms3Level($categories),
                                            'options' => ['placeholder' => Yii::t('app', '- Select category -'), 'size' => 2],
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
                                <div class="col-md-6">
                                    <?php echo $form->field($model, 'manufacture')
                                        ->widget(Select2::classname(), [
                                            'data' => \yii\helpers\ArrayHelper::map(
                                                $manufacturer, 'id', 'name'),
                                            'options' => ['placeholder' => Yii::t('app', '- Select manufacture -'), 'size' => 2],
                                            'pluginOptions' => [
                                                'allowClear' => true,
                                                'multiple' => true,
                                                'maximumInputLength' => 15,
                                                'tags' => true,
                                                'maximumSelectionLength' => 1,
                                            ],
                                            'showToggleAll' => false,
                                        ]) ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-row row">
                            <?= $form->field($model, 'model', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true])->label(Yii::t('app', 'Model') . ':') ?>
                            <?= $form->field($model, 'year',
                                ['options' =>
                                    ['class' => 'col-md-3', 'data-placeholder' => Yii::t('app', 'Please select')]])
                                ->dropDownList($years,
                                    ['prompt' => ' - ']
                                )
                                ->label(Yii::t('app', 'Year of manufacture')) ?>
                            <?= $form->field($model, 'condition', ['options' => ['class' => 'col-md-3']])
                                ->radioList(['1' => Yii::t('app', 'New'), '0' => Yii::t('app', 'Used')]) ?>
                        </div>
                        <div class="form-row row">
                            <?= $form->field($model, 'price',
                                ['options' => ['class' => 'col-md-6'],
                                    'template' => '{label}
                                            <div class="input-group">
                                          {input}
                                          <div class="input-group-addon"><i class="glyphicon glyphicon-euro"></i></div>
                                        </div>'])
                                ->textInput(['maxlength' => true])
                                ->label(Yii::t('app', 'Price') . ':') ?>
                            <?= $form->field($model, 'reference_number', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true]); ?>
                        </div>
                        <div class="form-row row">
                            <?= $form->field($model, 'status_user',
                                ['options' =>
                                    ['class' => 'col-md-3']])
                                ->dropDownList(
                                    Yii::$app->params['ad_user_statuses'],
                                    ['options' => ($model->isNewRecord && !$model->status_user) ? ['1' => ['selected ' => true]] : []]
                                ) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading5">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                           href="#collapse5" aria-expanded="true" aria-controls="collapse5">
                            <?= Yii::t('app', 'General specifications') ?>
                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                        </a>
                    </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading5">
                    <div class="panel-body">
                        <div class="form-row row">
                            <?= $form->field($model, 'power', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true]) ?>
                            <?= $form->field($model, 'pressure', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true]) ?>
                            <?= $form->field($model, 'weight', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="form-row row">
                            <?= $form->field($model, 'capacity', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true]) ?>
                            <?= $form->field($model, 'generatorOutput', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true]) ?>
                            <?= $form->field($model, 'voltage', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="form-row row">
                            <?= $form->field($model, 'tankVolume', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true]) ?>
                            <?= $form->field($model, 'operating_hours', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true]) ?>
                            <?= $form->field($model, 'mileage', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="form-row row">
                            <?= $form->field($model, 'bucket_capacity', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true]) ?>
                            <?= $form->field($model, 'tire_condition', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true]) ?>
                            <?= $form->field($model, 'color', [
                                'options' => [
                                    'class' => 'col-md-4',
                                    'data-placeholder' => Yii::t('app', 'Please select')
                                ]])->dropDownList(\yii\helpers\ArrayHelper::map(
                                $colors, 'id', 'name'), ['prompt' => ' - ']) ?>
                        </div>
                        <div class="form-row row">
                            <?= $form->field($model, 'length', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true]) ?>
                            <?= $form->field($model, 'width', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true]) ?>
                            <?= $form->field($model, 'height', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingThree">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                           href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                            <?= Yii::t('app', 'Listing Attachments') ?>
                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                        </a>
                    </h4>
                </div>
                <div id="collapseThree" class="panel-collapse collapse in" role="tabpanel"
                     aria-labelledby="headingThree">
                    <div class="panel-body">
                        <div class="image-upload-block cf">
                            <div class="sortable-photos">
                                <?php for ($i = 0; $i < 5; $i++): ?>
                                    <div class="item-photo pull-left">
                                        <figure class="img-offer" style="background-image: url(/images/img-2.png)">
                                            <!-- <img src="/images/img-2.png" alt="">-->
                                            <a href="#" class="btn-remove-img">
                                                <i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
                                        </figure>
                                    </div>
                                <?php endfor; ?>
                            </div>

                            <div class="image-upload-btn flexbox">
                                <i class="ic-add-image"></i>
                                <span><?= Yii::t('app', 'Add images') ?></span>
                            </div>
                        </div>
                        <div id="uploader">
                            <p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
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
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
<?php $this->registerCssFile('/files/plupload/js/jquery.ui.plupload/css/jquery.ui.plupload.css', ['position' => \yii\web\View::POS_HEAD, 'depends' => ['yii\web\YiiAsset']]); ?>
<!--<link rel="stylesheet" href="/files/plupload/js/jquery.ui.plupload/css/jquery.ui.plupload.css" type="text/css" />-->

<?= $this->registerJsFile('/files/plupload/js/plupload.full.min.js', ['position' => \yii\web\View::POS_END, 'depends' => ['frontend\assets\AppAsset']]) ?>
<?= $this->registerJsFile('/files/plupload/js/jquery.ui.plupload/jquery.ui.plupload.js', ['position' => \yii\web\View::POS_END, 'depends' => ['frontend\assets\AppAsset']]) ?>
<?= $this->registerJsFile('/files/plupload/js/i18n/ru.js', ['position' => \yii\web\View::POS_END, 'depends' => ['frontend\assets\AppAsset']]) ?>
<!-- production -->
<!--<script type="text/javascript" src="/files/plupload/js/plupload.full.min.js"></script>-->
<!--<script type="text/javascript" src="/files/plupload/js/jquery.ui.plupload/jquery.ui.plupload.js"></script>-->
<!--<script type="text/javascript" src="/files/plupload/js/i18n/ru.js"></script>-->
<script>
    window.onload = function() {

        $('.sortable-photos').sortable();
        var tabs = $("#tabs").tabs();
        tabs.find(".ui-tabs-nav").sortable({
            axis: "x",
            stop: function () {
                tabs.tabs("refresh");
            }
        });

        $('.editor').each(function (idx, el) {
            var id = $(el).attr('id');

            CKEDITOR.replace(id, {
                "toolbarGroups": [
                    {"name": "undo"},
                    {"name": "basicstyles", "groups": ["basicstyles", "cleanup"]},
                    {"name": "colors"}],
                "uiColor": "#FAFAFA"
            });
        });

        $("#uploader").plupload({
            // General settings
            runtimes : 'html5,flash,silverlight,html4',
            url : '/files/upload.php',

            // User can upload no more then 20 files in one go (sets multiple_queues to false)
            max_file_count: 20,

            chunk_size: '1mb',

            // Resize images on clientside if we can
//             resize : {
//             	width : 1000,
//             	height : 1000,
//             	quality : 90,
//             	crop: false // crop to exact dimensions
//             },

            filters : {
                // Maximum file size
                max_file_size : '1mb',
                // Specify what files to browse for
                mime_types: [
                    {title : "Image files", extensions : "jpg,gif,png"},
                    {title : "Zip files", extensions : "zip"}
                ]
            },

            // Rename files by clicking on their titles
            rename: true,

            unique_names: true,
            // Sort files
            sortable: true,

            // Enable ability to drag'n'drop files onto the widget (currently only HTML5 supports that)
            dragdrop: true,


            // autostart: true,

            // Views to activate
            views: {
                list: true,
                thumbs: true, // Show thumbs
                active: 'thumbs'
            },
            file_data_name: "files",
            // Flash settings
            flash_swf_url : '/files/plupload//js/Moxie.swf',

            // Silverlight settings
            silverlight_xap_url : '/files/plupload//js/Moxie.xap'
        });


        // Handle the case when form was submitted before uploading has finished
        $('#obj-form').submit(function(e) {
            // Files in queue upload them first
            if ($('#uploader').plupload('getFiles').length > 0) {
                // console.log($('#uploader').plupload('getFiles'));
                // return false;
                // When all files are uploaded submit form
                $('#uploader').on('complete', function(uploader, files) {
                    console.log(files);
                    // return false;
                    $('#obj-form')[0].submit();
                });

                $('#uploader').plupload('start');
            } else {
                alert("You must have at least one file in the queue.");
            }
            return false; // Keep the form from submitting
        });
    }
</script>

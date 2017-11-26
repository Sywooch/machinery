<?php

use yii\web\View;

\common\modules\image\Asset::register($this);

//dd($model);

$model_short = \yii\helpers\StringHelper::basename(get_class($model));

$upload_dir = $model->isNewRecord ? "files/temp" : "files/".strtolower($model_short)."/".$attribute;

$model_action = $model->isNewRecord ? 'create' : 'edit';
?>

<div id="upload-files"  class="image-upload-block cf clearfix">
    <div id="filelist"  class="sortable-photos">
        <?php foreach($model->$attribute as $img): ?>
<!--            --><?php //dd($img) ?>
            <div class="item-photo pull-left">
                <figure class="img-offer" style="background-image: url(<?= $img->path . '/' . $img->name ?>)">
                    <img src="<?= $img->path . '/' . $img->name ?>" alt="">
                    <a
                            href="<?= \yii\helpers\Url::to(['/image/manager/delete', 'id'=>$img->id, 'language'=> \common\modules\language\models\LanguageRepository::loadDefault()->local]) ?>"
                            class="btn-remove-img"
                            data-img="<?= $img->id ?>"
                            data-pjax="0"
                            data-confirm="<?= Yii::t('app', 'Are you sure you want to delete this item?') ?>"
                            data-method="post">
                        <i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
                </figure>
                <input type="hidden" id="img_name_<?= $img->id ?>"  class="img__name"  name="images[<?= $img->id ?>][name]" value="<?= $img->name ?>">
                <input type="hidden" id="delta_<?= $img->id ?>" class="img__delta" name="images[<?= $img->id ?>][delta]" value="<?= $img->delta ?>">
            </div>
        <?php endforeach; ?>
    </div>
    <div id="uploader" class="uploader-container-buttons">
        <a  href="javascript:;"  id="pickfiles" class="image-upload-btn flexbox">
            <i class="ic-add-image"></i>
            <span><?= Yii::t('app', 'Add images') ?></span>
        </a>
        <a id="uploadfiles" href="javascript:;" hidden>[Upload files]</a>
    </div>
    <pre id="console"></pre>
</div>
<p class="text-uppercase"><?= Yii::t('app', 'You can select up to {max} media files.', ['max'=>$max]) ?></p>


<?php //$this->registerCssFile('/files/plupload/js/jquery.ui.plupload/css/jquery.ui.plupload.css', ['position' => \yii\web\View::POS_HEAD, 'depends' => ['yii\web\YiiAsset']]); ?>

<?//= $this->registerJsFile('/files/plupload/js/plupload.full.min.js', ['position' => \yii\web\View::POS_END, 'depends' => ['frontend\assets\AppAsset']]) ?>
<?//= $this->registerJsFile('/files/plupload/js/jquery.ui.plupload/jquery.ui.plupload.js', ['position' => \yii\web\View::POS_END, 'depends' => ['frontend\assets\AppAsset']]) ?>

<?= $this->registerJsFile('/files/plupload/js/i18n/'.substr(Yii::$app->language, 0, 2).'.js', ['position' => \yii\web\View::POS_END, 'depends' => ['frontend\assets\AppAsset']]) ?>


<?= $this->registerJs('
$(function(){

try{
    $("body").on("click", ".btn-remove-img, .btn-remove-img", function(e){
        e.preventDefault();
        if(!confirm("'.  Yii::t('app', 'Are you sure you want to delete this item?') .'")) return false;
        var a = $(this);
        var id = a.data("img");
        var token = $(\'[name="csrf-token"]\').attr("content");
        var imgname = a.data("name");
        $.post("'. \yii\helpers\Url::to(['/image/manager/delete', 'language'=> \common\modules\language\models\LanguageRepository::loadDefault()->local]) . '", {id: id, token: token, imgname: imgname}, function(d){
//        return false;
            if(d.success==true){
                a.parents(".item-photo").fadeOut(200, function(){
                $(this).remove();
                });
            }
            return false;
        }, "json");
        return false;
    });
        
        } catch(e){console.log(e)}
        
        var multi_params = {
                _csrf: $(\'[name="csrf-token"]\').attr("content"),
                entity: "'. $model_short.'",
                field: "'. $attribute .'",
                model_action: "'. $model_action .'",
                upload_dir : "' . $upload_dir . '",
                model_id: "' . $model->id . '"
            };
            var uploadDir = "' . $upload_dir . '" ;

        var uploader = new plupload.Uploader({
            // General settings
            runtimes : "html5,flash,silverlight,html4",
            url : \'' . \yii\helpers\Url::to(['/image/manager/upload', 'language'=> \common\modules\language\models\LanguageRepository::loadDefault()->local]) . '\',

            browse_button : \'pickfiles\', // you can pass in id..
            container: document.getElementById(\'uploader\'),
            
            multipart_params: multi_params,
            max_file_count: 20,

//            chunk_size: \'1mb\',

            filters : {
                max_file_size : \'4mb\',
                mime_types: [
                    {title : "Image files", extensions : "jpg,gif,png"},
                    {title : "Zip files", extensions : "zip"}
                ]
            },
            rename: true,
            unique_names: true,

            autostart: true,
            file_data_name: "files",
            flash_swf_url : \'/files/plupload//js/Moxie.swf\',
            silverlight_xap_url : \'/files/plupload//js/Moxie.xap\',
            init: {
                PostInit: function() {
//                    document.getElementById(\'filelist\').innerHTML = \'\';
                    document.getElementById(\'uploadfiles\').onclick = function() {
                        uploader.start();
                        return false;
                    };
                },

                FilesAdded: function(up, files) {
                    uploader.start();
                    plupload.each(files, function(file) {
                        console.log("FILE : ",  file);

                        document.getElementById(\'filelist\').innerHTML += \'\' +
                            \'<div id="\' + file.id + \'" class="item-photo pull-left">\'
                            +\'<figure class="img-offer" style="">\'
                            +\'<img src="\'+location.origin+\'/files/images/loader.svg" alt="" id="img_\'+file.id+\'">\'
                            +\'<a href="/image/manager/delete" class="btn-remove-img" id="img_delete_\'+file.id+\'" data-img="\'+file.id+\'" >\'
                            +\'<i class="fa fa-times-circle-o" aria-hidden="true"></i></a>\'
                            + \'<span class="file-name">\' + file.name + \' (\' + plupload.formatSize(file.size) + \') <b></b></span>\'
                            +\'</figure>\'
                            +\'<input type="hidden" class="img__name" id="img_name_\'+file.id+\'" name="images[\'+file.id+\'][name]">\'
                            +\'<input type="hidden" class="img__delta" id="delta_\'+file.id+\'" name="images[\'+file.id+\'][delta]">\'
                            +\'</div>\';
                        $(\'#weidth_\'+file.id+\'\').val($(\'.item-photo\').length);
                    });
                },
                FileUploaded: function(up, file, res) {
                    deltaState();
                    response = $.parseJSON(res.response);
//                    console.log(response, res, file);
console.log(response);
                    $(\'img#img_\'+file.id).attr(\'src\', location.origin+\'/\'+uploadDir+\'/\'+file.target_name);
                    $(\'#img_name_\'+file.id+\'\').val(file.target_name);
                    $("#img_delete_"+file.id).attr("data-img", response.result.id).attr("data-name", response.filename);
                    
                },
                UploadComplete: function(up, files) {
                    console.log(files);
                },

                UploadProgress: function(up, file) {
                    document.getElementById(file.id).getElementsByTagName(\'b\')[0].innerHTML = \'<span>\' + file.percent + "%</span>";
                },

                Error: function(up, err) {
                    document.getElementById(\'console\').innerHTML += "\nError #" + err.code + ": " + err.message;
                }
            }
        });
        uploader.init();
        console.log(uploader);

/*
        // Handle the case when form was submitted before uploading has finished
        $(\'#uploader\').parents(\'form\').submit(function(e) {
            // Files in queue upload them first
            if ($(\'#uploader\').plupload(\'getFiles\').length > 0) {
                // console.log($(\'#uploader\').plupload(\'getFiles\'));
                // return false;
                // When all files are uploaded submit form
                $(\'#uploader\').on(\'complete\', function(uploader, files) {
                    console.log(files);
                    // return false;
                    $(\'#obj-form\')[0].submit();
                });

                $(\'#uploader\').plupload(\'start\');
            } else {
                alert("You must have at least one file in the queue.");
            }
            return false; // Keep the form from submitting
        });
        */
        
    })
        var deltaState = function (){
            $(".item-photo").each(function(idx, el){
                $(el).find("input.img__delta").val(idx);
                console.log(idx);
            });
        }
', View::POS_END) ?>


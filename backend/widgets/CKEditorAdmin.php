<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backend\widgets;

//use dosamigos\ckeditor\CKEditor;
use Yii;
use iutbay\yii2kcfinder\KCFinderAsset;
use yii\helpers\ArrayHelper;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;
 use dosamigos\ckeditor\CKEditorTrait;
/**
 * Description of CKeditor
 *
 * @author befre
 */
class CKEditorAdmin extends \dosamigos\ckeditor\CKEditor {

    

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->initOptions();
    }
    public $enableKCFinder = true;


     public function run()
    {
         if ($this->hasModel()) {
            echo Html::activeTextarea($this->model, $this->attribute, $this->options);
        } else {
            echo Html::textarea($this->name, $this->value, $this->options);
        }
        $this->registerPlugin2();
    }
   
    /**
     * Registers CKEditor plugin
     * @codeCoverageIgnore
     */
    protected function registerPlugin2()
    {
        if ($this->enableKCFinder)
            $this->registerKCFinder();
        $this->registerPlugin();
              
    }

    protected function registerKCFinder() {

        $_SESSION['KCFINDER'] = [
            'disabled' => false,
            'uploadURL' => '/upload',
            'uploadDir' => Yii::getAlias('@frontend/web/upload')
        ];

        $register = KCFinderAsset::register($this->view);
        $kcfinderUrl = $register->baseUrl;

        $browseOptions = [
            'filebrowserBrowseUrl' => $kcfinderUrl . '/browse.php?opener=ckeditor&type=files',
            'filebrowserUploadUrl' => $kcfinderUrl . '/upload.php?opener=ckeditor&type=files',
            'filebrowserImageBrowseUrl' => $kcfinderUrl . '/browse.php?opener=ckeditor&type=images',
            'filebrowserImageUploadUrl' => $kcfinderUrl . '/upload.php?opener=ckeditor&type=images',
        ];

        $this->clientOptions = ArrayHelper::merge($browseOptions, $this->clientOptions);
    }

}

<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\modules\file\models\File;
use common\modules\import\models\ImportImage;
use common\modules\import\indexers\ImageFromUrl;
use common\modules\import\helpers\ImportHelper;

class ImagesController extends Controller 
{
  
    const IMPORT_IMAGE_PER_REQUEST = 100;

    public function actionIndex()
    {
        
        $ImportHelper = \Yii::$container->get(ImportHelper::class);
        
        $image = ImportImage::find()
                ->limit(self::IMPORT_IMAGE_PER_REQUEST)
                ->all();

        foreach($image as $item){
            if(($data = $ImportHelper->copy($item)) == false){
                continue;
            }
            $file = new File();
            $file->setAttributes((array)$data);
            
            if($file->save()){
                $item->delete();
            }
        }
    }
}

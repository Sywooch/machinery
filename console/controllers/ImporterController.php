<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\modules\import\models\Sources;
use common\modules\import\models\Validate;
use common\modules\import\Import;
use common\modules\import\helpers\ImportHelper;
use common\modules\import\models\TemporaryTerms;

class ImporterController extends Controller 
{
    const MAX_IMPORT_ERRORS = 100;

    public function actionIndex()
    {
        $sources = Sources::find()
                ->where([
                    'status' => Sources::STATUS_ACTIVE
                ])
                ->andWhere(['<', 'tires' , Sources::TIRES])
                ->all();
        
        $validator = Yii::$container->get(Validate::class); 
        $terms = Yii::$container->get(TemporaryTerms::class);

        foreach($sources as $source){
           
            $import = Yii::$container->get(Import::class, [$source]); 
            if(!$import->getFile()){
                $source->addMessage('[1000] Файл не найден или не может быть прочитан.');
                continue;
            }
            
            while (($line = $import->read()) !== FALSE) {

                if(($line = $import->parseTerms($line)) === false){
                    $source->addMessage('[1001] Ошибка парсинга терминов.');
                    continue;
                }
                
                if(($line = $import->parseImages($line)) === false){
                    $source->addMessage('[1001] Ошибка парсинга изображений.');
                    continue;
                }
             
                $validator->setAttributes($line);
                $validator->source_id = $source->id;
                $validator->user_id = 1;
                
                if($validator->validate()){
                    $import->add($validator);
                }else{
                    foreach($validator->getErrors() as $field => $errors){
                        foreach($errors as $error){
                            $source->addMessage("{$field} {$error}", $validator); 
                            echo $source->getLastMessage(),"\n\r";
                        }
                    }
                    if($source->countMessages() > self::MAX_IMPORT_ERRORS){
                        $source->addMessage("Превышен лимит максимального количества ошибок. Операции прекращены."); 
                        exit('Max error exit.');
                    }
                }
            } 
            
            $import->flush();
            $import->close();
            $source->save();
        }
    }
}

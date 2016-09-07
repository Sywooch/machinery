<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\modules\import\models\Sources;
use common\modules\import\models\Validate;
use common\modules\import\Import;
use common\modules\import\models\TemporaryTerms;
use yii\helpers\Console;
use common\modules\import\helpers\ImportHelper;

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
        
       // $validator = Yii::$container->get(Validate::class); 
        $terms = Yii::$container->get(TemporaryTerms::class);

        foreach($sources as $source){
           
            $validator = new Validate(); 
            $validator->source_id = $source->id;
            $validator->user_id = 1;
            
            $this->stdout("Source: {$source->name}\n", Console::FG_GREEN);
            $import = Yii::$container->get(Import::class, [$source]);   
            if(!$import->getFile()){
                $source->addMessage('[1000] Файл не найден или не может быть прочитан.');
                $this->stdout("[1000] Файл не найден или не может быть прочитан.\n", Console::FG_RED);  
                continue;
            }

            while (($line = $import->read()) !== FALSE) {

                $validator->sku = $line['sku'];
                
                if(($line = $import->parseTerms($line)) === false){
                    $source->addMessage('[1001] Ошибка парсинга терминов.', $validator);
                    $this->stdout("[1001] Ошибка парсинга терминов.\n", Console::FG_YELLOW);  
                    continue;
                }
                
                if(($line = $import->parseImages($line)) === false){
                    $source->addMessage('[1002] Ошибка парсинга изображений.', $validator);
                    $this->stdout("[1002] Ошибка парсинга изображений.\n", Console::FG_YELLOW); 
                    continue;
                }
                
                $validator->setAttributes($line);
                $validator->group = ImportHelper::getGroup($validator->attributes);
               
                if($validator->validate()){
                    $import->add($validator);
                }else{
                    foreach($validator->getErrors() as $field => $errors){
                        foreach($errors as $error){
                            $source->addMessage("{$field} {$error}", $validator); 
                            $this->stdout("[1004] [{$validator->sku}] {$error}\n"); 
                        }
                    }
                    if($source->countMessages() > self::MAX_IMPORT_ERRORS){
                        $source->addMessage("Превышен лимит максимального количества ошибок. Операции прекращены."); 
                        $this->stdout("[1003] Превышен лимит максимального количества ошибок. Операции прекращены.\n", Console::FG_RED); 
                        break;
                    }
                }
            } 
            
            $import->flush();
            $import->close();
            $source->save();
        }
    }
}

<?php

namespace console\modules\import\controllers;

use Yii;
use yii\console\Controller;
use console\modules\import\models\Sources;
use console\modules\import\models\Validate;
use console\modules\import\Import;
use console\modules\import\helpers\ImportHelper;
use console\modules\import\models\TemporaryTerms;

/**
 * ItemsController implements the CRUD actions for TaxonomyItems model.
 */
class DefaultController extends Controller
{
    public function actions()
    {
        return [
        ];
    }
   
    public function actionIndex()
    {
        $sources = Sources::find()->where(['<', 'tires' , Sources::TIRES])->all();
        $validator = Yii::$container->get(Validate::class); 
        $terms = Yii::$container->get(TemporaryTerms::class);

        foreach($sources as $source){
           
            $import = Yii::$container->get(Import::class, [$source]); 
            if(!$import->file){
                $source->addMessage('[1000] Файл не найден или не может быть прочитан.');
                continue;
            }
            
            while (($line = $import->read()) !== FALSE) {

                if(($line = $import->parseTerms($line)) === false){
                    $source->addMessage('[1001] Ошибка парсинга терминов.');
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
                           $source->addMessage("[1001] {$field} {$error}"); 
                        }
                    }
                    $validator->clearErrors(); 
                }
            } 
            $import->flush();
            $import->close();
            $source->save();
        }
    }
}

<?php

namespace console\modules\import\controllers;

use Yii;
use yii\console\Controller;
use console\modules\import\models\Sources;
use console\modules\import\models\Validate;

/**
 * ItemsController implements the CRUD actions for TaxonomyItems model.
 */
class DefaultController extends Controller
{
    const TIRES = 500;
    const INSERT_LIMIT  = 1000;


    public function actions()
    {
        return [
        ];
    }
   
    public function actionIndex()
    {
        $sources = Sources::find()->where(['<', 'tires' , self::TIRES])->all();
        
        foreach($sources as $source){
           
            $fileName = \Yii::getAlias('@app')."/../files/import/source_{$source->id}.csv";
            
            if (($handle = fopen($fileName, "r")) === FALSE) {
                $source->addMessage('[1000] Файл не найден или не может быть прочитан.');
                continue;
            }
            
            $data = [];
            $fields = [];
            $validator = new Validate();
            while (($line = fgetcsv($handle, 2000, ";")) !== FALSE) {
                if(empty($fields)){
                    $fields = $line;
                    continue;
                }
                $validator->setAttributes(array_combine($fields, $line));
                if($validator->validate()){
                    $data[] = $validator->attributes;
                }else{
                    foreach($validator->getErrors() as $field => $errors){
                        foreach($errors as $error){
                           $source->addMessage("[1001] {$field} {$error}"); 
                        }
                    }
                }
                
                if(count($data) >= self::INSERT_LIMIT){
                    // TODO: bathInsert
                    $data = [];
                }
                
            }
            if(count($data)){
                // TODO: bathInsert
                $data = [];
            }
            fclose($handle);
            $source->tires++;
            $source->save();
        }
    }
}

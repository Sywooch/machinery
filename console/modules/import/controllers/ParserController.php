<?php

namespace console\modules\import\controllers;

use Yii;
use yii\console\Controller;
use console\modules\import\models\Sources;
use console\modules\import\Parser;


/**
 * ItemsController implements the CRUD actions for TaxonomyItems model.
 */
class ParserController extends Controller
{
    public function actions()
    {
        return [
        ];
    }
   
    public function actionIndex()
    {
        $sources = Sources::find()->where(['<', 'tires' , Sources::TIRES])->all();
        foreach($sources as $source){
           
            $parser = new Parser($source);
            $file = file_get_contents($source->url);
            $lines = explode(PHP_EOL, $file);
            unset($file);
            $data = [];
            foreach ($lines as $line) {
                $csv = str_getcsv($line, ';');
                $data[] = $parser->prepare($csv); 
            }
            print_r($data); exit('a');
            $source->tires++;
            $source->save();
        }
    }
}

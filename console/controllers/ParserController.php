<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\modules\import\models\Sources;
use common\modules\import\Parser;


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
        $sources = Sources::find()
                ->where([
                    'status' => Sources::STATUS_ACTIVE
                ])
                ->andWhere(['<', 'tires' , Sources::TIRES])
                ->all();

        foreach($sources as $source){
           
            $parser = new Parser($source);
            $file = file_get_contents($source->url);
            
            if(!$file){
                $source->tires++;
                $source->save();
                continue;
            }
            
            $lines = explode(PHP_EOL, $file);
            unset($file);
            foreach ($lines as $line) {
                $csv = str_getcsv($line, ';');
                $data = $parser->prepare($csv); 
                $parser->write($data);
            }

            $source->save();
        }
    }
}

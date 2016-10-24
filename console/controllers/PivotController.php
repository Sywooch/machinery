<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\modules\product\models\ProductIndex;


class PivotController extends Controller 
{
    public function actionIndex()
    {
        $models = Yii::$app->params['catalog']['models'];
        
        foreach($models as $model){
            $model = new $model();  
            $this->createTable($model);
           // $this->insertData($model);
        }
    }
    
    private function insertData($model){
        $table = $model->tableName();
       
        $sql = "";
        $sql .= "INSERT IGNORE {$table}_index_pivot \n";
        $sql .= "select tbl0.entity_id as id \n";
        
        $vocabularyIds = Yii::$app->db->createCommand("SELECT DISTINCT vocabulary_id FROM {$table}_index")->queryColumn();
        if(empty($vocabularyIds)){
            return;
        }
        foreach($vocabularyIds as $id){
            $sql .= ", max(tbl0.term_id*(1-abs(sign(tbl0.vocabulary_id-{$id})))) as t{$id}  \n";  
        }
        $sql .= " from {$table}_index tbl0  group by tbl0.entity_id;";
    
        Yii::$app->db->createCommand($sql)->execute();
        
     /*   
        $sql = "";
      
        $sql .= "select entity_id as id \n";
        
        $vocabularyIds = Yii::$app->db->createCommand("SELECT DISTINCT vocabulary_id FROM {$table}_index")->queryColumn();
        if(empty($vocabularyIds)){
            return;
        }
        foreach($vocabularyIds as $id){
            $sql .= ", max(term_id*(1-abs(sign(vocabulary_id-{$id})))) as t{$id}  \n";  
        }
        $sql .= " from {$table}_index  i join taxonomy_items ti ON ti.id = i.term_id  group by entity_id, term_id ORDER BY entity_id, weight DESC";
        
        $sql2 = "INSERT IGNORE {$table}_index_pivot \n";
        $sql2 .= "select id,t1 \n";
        foreach($vocabularyIds as $id){
            if($id==1){
                continue;
            }
            $sql2 .= ", max(t{$id}) as t{$id}  \n";  
        }
        $sql2 .= ' from ('.$sql."\n";  
        $sql2 .= ") sb GROUP BY id  \n";  
        
        
        Yii::$app->db->createCommand($sql)->execute();
        */
        
        
    }


    private function createTable($model){
        $table = $model->tableName();
     
        $sql = "";
        $sql .= "DROP TABLE IF EXISTS {$table}_index_pivot;\n";
        $sql .= "CREATE TABLE {$table}_index_pivot (\n";
        $sql .= "`id` BIGINT(20) NOT NULL, \n";

        $vocabularyIds = Yii::$app->db->createCommand("SELECT DISTINCT vocabulary_id FROM {$table}_index")->queryColumn();
        if(empty($vocabularyIds)){
            $sql .= "`t1` INT(11) NOT NULL, \n";  
        }
        foreach($vocabularyIds as $id){
            $sql .= "`t{$id}` INT(11) NOT NULL, \n";  
        }
        
        $sql .= "PRIMARY KEY (`id`), \n";
        $sql .= "INDEX `t1` (`t1`) \n";
        $sql .= ") \n COLLATE='utf8_unicode_ci' \n";
        $sql .= "ENGINE=MyISAM; \n";
        
 $sql = "DROP TABLE IF EXISTS {$table}_index_pivot;\n";
        Yii::$app->db->createCommand($sql)->execute();
    }
}

<?php
namespace console\modules\import;

use Yii;
use console\modules\import\models\Sources;
use console\modules\import\helpers\ImportHelper;
use console\modules\import\models\Insert;
use console\modules\import\models\Validate;

class Import{
    
    private $_file;
    private $_helper;
    private $_insert;
    private $_fields = [];

    public function __construct(Sources $source, ImportHelper $helper, Insert $insert) {
        $this->_file = fopen(Yii::getAlias('@app').'/../files/import/source_' . $source->id . 'a.csv', 'r');
        $this->_helper = $helper;
        $this->_insert = $insert;
    } 
    
    public function getFile(){
        return $this->_file;
    }
    
    public function read(){
        $line = fgetcsv($this->_file, 2000, ";");
        if($line !== false && empty($this->_fields)){
            $this->_fields = $line;
            $line = fgetcsv($this->_file, 2000, ";");
        }
        if($line !== false){
            array_walk($line, function(&$item){
               $item = rtrim(trim($item, '"'),'"');
            });
            $line = array_combine($this->_fields, $line);
        }
        return $line;
    }
    
    public function parseTerms(array $data){
        return $this->_helper->parseTerms($data);
    }
    
    public function parseImages(array $data){
        return $this->_helper->parseImages($data);
    }
    
    public function getFields(){
        return $this->_fields;
    }
    
    public function add(Validate $validator){
        $this->_insert->add($validator->attributes);
    }
    
    public function flush(){
        $this->_insert->flush();
    }
    
    public function close(){
        fclose($this->_file);
    }
    
}

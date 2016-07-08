<?php
namespace common\modules\import;

use Yii;
use common\modules\import\models\Sources;

class Parser{
    
    private $_parser;
    private $_fields;
    private $file;
    private $header = false;

    public function __construct(Sources $source) {
        $class = '\\common\\modules\\import\\parsers\\'.$source->type;
        $this->_parser = new $class($source);
        $this->_fields = get_class_methods($this->_parser);
        $constructorIndex = array_search('__construct', $this->_fields);
        unset($this->_fields[$constructorIndex]);
        $this->file = fopen(Yii::getAlias('@app').'/../files/import/source_' . $source->id . 'a.csv', 'w');
    }
    
    public function prepare(array $data){
        $return = [];
        foreach($this->_fields as $method){
            $return[$method] = $this->_parser->$method($data);
        }
        return $return;
    }
    
    public function getFields(){
        return $this->_fields;
    }
    
    public function write(array $data){
        if(empty($data)){
            return;
        }
        if($this->header === false){
            fputcsv($this->file, array_keys($data), ';');
            $this->header = true;
        }
        fputcsv($this->file, $data, ';');
    }
    
}

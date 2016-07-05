<?php

namespace console\modules\import;
use console\modules\import\models\Sources;

class Parser{
    
    private $_parser;
    private $_fields;


    public function __construct(Sources $source) {
        $class = '\\console\\modules\\import\\parsers\\'.$source->type;
        $this->_parser = new $class($source);
        $this->_fields = get_class_methods($this->_parser);
        $constructorIndex = array_search('__construct', $this->_fields);
        unset($this->_fields[$constructorIndex]);
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
    
}

<?php
namespace console\modules\import\parsers;

use console\modules\import\ParserInterface;
use console\modules\import\models\Sources;

class Tyretrader implements ParserInterface{
    
    private $_source;
    
    public function __construct(Sources $source){
        $this->_source = $source;
    }
    
    public function sku(array $data){
        return $this->_source->id . '-' . time() ;
    }
    
    public function title(array $data){
        return $data[4];
    }
    
    public function description(array $data){
        return '';
    }
    
    public function price(array $data){
        $number = (float)str_replace(',', '.', $data[10]);
        return number_format($number, 2, '.','');
    }
    
    public function available(array $data){
        return 1;
    }
}

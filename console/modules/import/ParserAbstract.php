<?php
namespace console\modules\import;

use console\modules\import\models\Sources;
use console\modules\import\ParserInterface;

abstract class ParserAbstract implements ParserInterface
{
    private $_source;
    protected $map = [];
    
    public function __construct(Sources $source){
        $this->_source = $source;
    }
    
    public function sku(array $data){
        return $this->_source->id . '-' . $data[$this->map['id']] ;
    }
    
    public function title(array $data){
        return '"'.$data[$this->map['title']].'"';
    }
    
    public function description(array $data){
        return '';
    }
    
    public function price(array $data){
        $number = (float)str_replace(',', '.', $data[$this->map['price']]);
        return number_format($number, 2, '.','');
    }
    
    public function available(array $data){
        return 1;
    }

    public function images(array $data){
        $images = [];
        $images[] = ['photos' =>  basename($data[$this->map['images']])];
        $temporary = [];
        foreach($images as $item){
            foreach($item as $key => $value){
                $temporary[] = $key . ':' . $value;
            }
        }

        return '"'.implode(';', $temporary).'"';

    }
    
}

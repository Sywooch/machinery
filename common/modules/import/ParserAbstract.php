<?php
namespace common\modules\import;

use common\modules\import\models\Sources;
use common\helpers\URLify;

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
    
    public function group(array $data){
        return URLify::url ($data[$this->map['vendor']], 50) . '/' . URLify::url ($data[$this->map['model']], 50);
    }

    public function model(array $data){
        return $data[$this->map['model']];
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

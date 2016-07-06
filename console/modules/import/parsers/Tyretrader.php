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
        return $this->_source->id . '-' . $data[2] ;
    }
    
    public function title(array $data){
        return '"'.$data[5].'"';
    }
    
    public function description(array $data){
        return '';
    }
    
    public function price(array $data){
        $number = (float)str_replace(',', '.', $data[11]);
        return number_format($number, 2, '.','');
    }
    
    public function available(array $data){
        return 1;
    }
    
    public function terms(array $data){
        $terms = [
            'Каталог' => 'Автомобильные диски',
            'Бренд' => $data[0],
            'Диаметр диска' => $data[3],
            'Ширина диска' => $data[4],
            'Крепеж' => $data[6],
            'PCD' => $data[7],
            'Вылет (ET)' => $data[8],
            'Диаметр ступицы (DIA)' => $data[9],
            'Цвет' => $data[10]
        ];
        $temporary = [];
        foreach($terms as $key => $value){
            $temporary[] = $key . ':' . $value;
        }
        
        return '"'.implode(';', $temporary).'"';
    }
}

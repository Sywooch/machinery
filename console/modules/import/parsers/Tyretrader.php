<?php
namespace console\modules\import\parsers;

use console\modules\import\ParserInterface;
use console\modules\import\models\Sources;

class Tyretrader implements ParserInterface{
    
    private $_source;
    
    private $map = [
        'id' => 3,
        'type' => 0,
        'vendor' => 1,
        'radius' => 4,
        'width' => 5,
        'title' => 6,
        'krepej' => 7,
        'pcd' => 8,
        'et' => 10,
        'dia' => 11,
        'color' => 12,
        'images' => 14,
        'price' => 13
    ];


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
    
    public function terms(array $data){
        $terms = [];
        
        $terms[] = ['Каталог' => 'Автомобильные диски'];
        $terms[] = ['Тип диска' => $data[$this->map['type']]];
        $terms[] = ['Бренд' => $data[$this->map['vendor']]];
        $terms[] = ['Диаметр диска' => $data[$this->map['radius']]];
        $terms[] = ['Ширина диска' => $data[$this->map['width']]];
        $terms[] = ['PCD' => $data[$this->map['krepej']] . 'x' . $data[$this->map['pcd']]];
        $terms[] = ['Вылет (ET)' => $data[$this->map['et']]];
        $terms[] = ['Диаметр ступицы (DIA)' => $data[$this->map['dia']]];
        $terms[] = ['Цвет' => $data[$this->map['color']]];
        
        $temporary = [];
        foreach($terms as $item){
            foreach($item as $key => $value){
                $temporary[] = $key . ':' . $value;
            }
        }
        return '"'.implode(';', $temporary).'"';
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

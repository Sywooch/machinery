<?php
namespace console\modules\import\parsers;

use console\modules\import\ParserAbstract;
use console\modules\import\models\Sources;

class TyretraderTire extends ParserAbstract{
    
    protected $map = [
        'id' => 3,
        'season' => 4, 
        'vendor' => 0, 
        'radius' => 8, 
        'width' => 6, 
        'height' => 7, 
        'title' => 2, 
        'capacityIndex' => 9,
        'speedIndex' => 10, 
        'ship' => 12,
        'tranportType' => 5,
        'strengthenedTire' => 11, 
        'images' => 16, 
        'price' => 15 
    ];

    public function terms(array $data){
        $terms = [];

        $terms[] = ['Каталог' => 'Автомобильные шины'];
        $terms[] = ['Сезон' => $data[$this->map['season']]];
        $terms[] = ['Бренд' => $data[$this->map['vendor']]];
        $terms[] = ['Диаметр' => $data[$this->map['radius']]];
        $terms[] = ['Ширина профиля' => $data[$this->map['width']]];
        $terms[] = ['Высота профиля' => $data[$this->map['height']]];
        $terms[] = ['Индекс нагрузки' => $data[$this->map['capacityIndex']]];
        $terms[] = ['Индекс скорости' => $data[$this->map['speedIndex']]];
        $terms[] = ['Шип/нешип' => $data[$this->map['ship']]];
        $terms[] = ['Тип транспортного средства' => $data[$this->map['tranportType']]];
        $terms[] = ['Усиленная шина' => $data[$this->map['strengthenedTire']]];
        
        $temporary = [];
        foreach($terms as $item){
            foreach($item as $key => $value){
               if($value == ''){
                   continue;
               }
               $temporary[] = $key . ':' . $value;
            }
        }
        return '"'.implode(';', $temporary).'"';
    }
   
}

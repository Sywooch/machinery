<?php
namespace common\modules\import\parsers;

use common\modules\import\ParserAbstract;
use common\modules\import\models\Sources;

class TyretraderDisk extends ParserAbstract{

    protected $map = [
        'id' => 3,
        'type' => 0,
        'vendor' => 1,
        'model' => 2,
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

    public function terms(array $data){
        $terms = [];
        
        $terms[] = ['Каталог' => 'Автомобильные диски'];
        $terms[] = ['Тип диска' => $data[$this->map['type']]];
        $terms[] = ['Бренд' => $data[$this->map['vendor']]];
        $terms[] = ['Диаметр' => $data[$this->map['radius']]];
        $terms[] = ['Ширина диска' => $data[$this->map['width']]];
        $terms[] = ['PCD' => $data[$this->map['krepej']] . 'x' . $data[$this->map['pcd']]];
        $terms[] = ['Вылет (ET)' => $data[$this->map['et']]];
        $terms[] = ['Диаметр ступицы (DIA)' => $data[$this->map['dia']]];
        $terms[] = ['Цвет' => $data[$this->map['color']]];
        
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

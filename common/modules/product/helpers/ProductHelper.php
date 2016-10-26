<?php

namespace common\modules\product\helpers;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\Alias;
use common\helpers\URLify;
use common\helpers\ModelHelper;
use common\modules\taxonomy\helpers\TaxonomyHelper;

class ProductHelper {
    
    const STATUS_TERMS_VID = 47;


    /**
     * 
     * @param object $product
     * @return []
     */
    public static function getBreadcrumb($entity){
        $breadcrumb = [];
        $breadcrumb[] = ['label' => 'Каталог', 'url' => '/catalog'];
        $url = '';
        foreach($entity->catalog as $taxonomyItem){
            $url .= '/'.$taxonomyItem->transliteration;
            $breadcrumb[] = ['label' => Html::encode($taxonomyItem->name), 'url' => $url];
        }
        $breadcrumb[] = Html::encode($entity->title);
        return $breadcrumb;
    }
    
    public static function getStatuses(array $terms){
        $return = [];
        foreach($terms as $term){
            if($term->vid == self::STATUS_TERMS_VID){
                $return[] = $term;
            }
        }
        return $return;
    }
    
    /**
     * 
     * @param mixed $product
     * @return int
     */
    public function promoPrice($product){
        if(isset($product->promoCode)){
            return $product->price - $product->promoCode->discount;
        }
        return $product->price;
    }
    
    /**
     * 
     * @param mixed $product
     * @return string
     */
    public function shortPattern($product){
       return '';
    }
    
    /**
     * 
     * @param mixed $product
     * @return string
     */
    public function titlePattern($product){
        $title = [];
        $title[] = $product->title;
        $title[] = ArrayHelper::getValue($product->terms, '36.name'); // OC
        $title[] = ArrayHelper::getValue($product->terms, '31.name'); // color
        $title = array_filter($title);
        return implode(' ', $title);
    }
    
    /**
     * 
     * @param mixed $product
     * @return string
     */
    public function urlPattern($product, Alias $alias){
        $alias->alias = URLify::url($product->helper->titlePattern($product)) .'-'. $product->id;     
        $alias->url = 'product/default' . '?id=' . $product->id . '&model='. ModelHelper::getModelName($product);
        $alias->groupAlias = URLify::url($product->title);

        $link = ArrayHelper::getColumn(TaxonomyHelper::order($product->catalog), 'transliteration');
        $alias->prefix = implode('/', $link);
        
        return $alias;
    }
    
    /**
     * 
     * @param [] $attributes
     * @return int
     */
    public static function createGroup($attributes){
        $group = [];
        $group[] = $attributes['model'];
        return crc32(implode(' ', $group));
    }
    
    
}
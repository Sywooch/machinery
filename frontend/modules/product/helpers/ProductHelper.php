<?php

namespace frontend\modules\product\helpers;

use yii\helpers\Html;
use yii\base\InvalidParamException;
use common\modules\taxonomy\models\TaxonomyItems;

class ProductHelper {
    
    /**
     * 
     * @param object $product
     * @return []
     */
    public function getBreadcrumb($entity){
        $breadcrumb = [];
        foreach($entity->catalog as $taxonomyItem){
            $breadcrumb[] = ['label' => Html::encode($taxonomyItem->name), 'url' => $taxonomyItem->transliteration];
        }
        $breadcrumb[] = Html::encode($entity->title);
        return $breadcrumb;
    }
}
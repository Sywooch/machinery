<?php

namespace frontend\modules\catalog\helpers;

use Yii;
use yii\helpers\ArrayHelper;
use common\modules\taxonomy\models\TaxonomyItems;
use frontend\modules\catalog\components\FilterParams;

class FilterHelper { 
    public static function isActive(FilterParams $filter, TaxonomyItems $term){
        if(isset($filter->index[$term->vid][$term->id])){
            return true;
        }
        return false;
    }
}
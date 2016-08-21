<?php

namespace frontend\modules\product\components;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use frontend\modules\product\models\ProductRepository;
use common\modules\taxonomy\models\TaxonomyItems;
use yii\helpers\ArrayHelper;
use common\helpers\ModelHelper;

class ProductBehavior extends Behavior
{
    
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSaveProduct',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSaveProduct'
        ];
    }
    
    /** @inheritdoc */
    public function beforeSaveProduct($insert) {
        $terms = TaxonomyItems::find()->indexBy('vid')->where(['id'=>$this->owner->terms])->all();
        $this->owner->group = $this->getGroup($terms);
    }
    
    /**
     * 
     * @return float
     */
    public function getGroupRating(){
        $search = new ProductRepository($this->owner);
        return $search->getGroupRatingByModel($this->owner);
    }

    /**
     * 
     * @param array $terms
     * @return int
     */
    private function getGroup(array $terms){
        $group = [];
        $group[] = ArrayHelper::getValue($terms, '1.name'); // brand
        $group[] = $this->owner->model;
        $group[] = ModelHelper::getModelName($this->owner);
        return crc32(implode(' ', $group));
    }
}

?>
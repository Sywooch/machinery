<?php

namespace common\modules\product\components;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use common\modules\product\models\ProductRepository;
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
        $group[] = ArrayHelper::getValue($terms, '2.name'); // brend
        $group[] = $this->owner->model;
        $group[] = ModelHelper::getModelName($this->owner);
        return crc32(implode(' ', $group));
    }
    
    public function getShortDescription(){
        $model = $this->owner;
        if($model->short){
            return $model->short;
        }
        $model->short = $this->shortPattern();
        $model::updateAll(['short' => $model->short ], ['id' => $model->id]);
        return $model->short;
    }
    
    public function getTitleDescription(){
       return $this->titlePattern();
    }
    
    /**
     * 
     * @return string
     */
    public function shortPattern(){
        if(method_exists ( $this->owner , 'shortPattern' )){
            return $this->owner->shortPattern();
        }
        $terms = ArrayHelper::index($this->terms, 'vid');
        $short = [];
        $short[] = ArrayHelper::getValue($terms, '36.name'); // OC
        $short = array_filter($short);
        return implode(',', $short);
    }
    
    /**
     * 
     * @return string
     */
    public function titlePattern(){
        if(method_exists ( $this->owner , 'titlePattern' )){
            return $this->owner->titlePattern();
        }
        $terms = ArrayHelper::index($this->owner->terms, 'vid');
        $title = [];
        $title[] = $this->owner->title;
        $title[] = ArrayHelper::getValue($terms, '36.name'); // OC
        $title[] = ArrayHelper::getValue($terms, '31.name'); // color
        $title = array_filter($title);
        return implode(' ', $title);
    }
}

?>
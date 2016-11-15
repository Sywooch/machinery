<?php

namespace common\modules\store\models;

use Yii;
use common\modules\store\Finder;
use common\modules\taxonomy\models\TaxonomyItems;

class FilterModel extends \yii\base\Model
{
    
    protected $_model;
    protected $_indexModel;
    
    public $_priceRange = '250, 10000';
    public $_priceMin;
    public $_priceMax;
    public $index;

    public function __construct(Finder $finder = null) {
        if($finder !== null){
            $this->_model = $finder->model;
        }
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['priceMin', 'priceMax'], 'integer'],
            [['index'], 'safe']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'priceRange' => 'Подобрать по цене:',
        ];
    }
    
    /**
     * 
     * @return string
     */
    public function getPriceRange(){
        return implode(',', [$this->priceMin, $this->priceMax]);
    }
    
    
    /**
     * 
     * @return int
     */
    public function getPriceMin(){
        if($this->_priceMin === null){
           $this->_priceMin = 950;
        }
        return $this->_priceMin;
    }
    
    /**
     * 
     * @param int $price
     */
    public function setPriceMin($price){
        $this->_priceMin = $price;
    }
    
    /**
     * 
     * @return int
     */
    public function getPriceMax(){
        if($this->_priceMax === null){
           $this->_priceMax = 20000;
        }
        return $this->_priceMax;
    }
    
    /**
     * 
     * @param int $price
     */
    public function setPriceMax($price){
        $this->_priceMax = $price;
    }

    /**
     * 
     * @param int $catalogId
     * @return []
     */
    public function getFilterTermIds(TaxonomyItems $catalogTerm){

            return (new \yii\db\Query())
                            ->select('id')
                            ->from('(SELECT unnest(index) as id FROM '.$this->_model->tableName().' WHERE index && ARRAY['.$catalogTerm->id.']) as t0')
                            ->distinct()
                            ->column();  
    }
    

}

<?php

namespace common\modules\store;

use yii\base\Object;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use common\modules\store\components\StoreUrlRule;
use common\modules\store\models\ProductInterface;
use common\modules\store\models\ProductSearch;
use common\modules\store\models\ComparesSearch;
use common\helpers\ModelHelper;
use common\modules\store\classes\uus\UUS;
use common\modules\taxonomy\models\TaxonomyItems;

class Finder extends Object{
    
    public $module;
    public $model;
    public $produtSearch;
    public $comparesSeach;
    
    private $_uus;


    public function __construct(ProductInterface $model, ProductSearch $produtSearch, ComparesSearch $comparesSearch, UUS $uus, $config = array()) {
        
        $this->_uus = $uus;
        $this->model = $model;
        $this->produtSearch = $produtSearch;
        $this->produtSearch->model = $model;
        $this->comparesSeach = $comparesSearch;
        
        parent::__construct($config);
    }
    
    /**
     * 
     * @param StoreUrlRule $url
     * @return ActiveDataProvider
     */
    public function search(StoreUrlRule $url){
        $query = $this->model::find()
                ->with([
                    'terms',
                    'files',
                    'alias',
                    'groupAlias'  
                ]);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $this->module->defaultPageSize,
            ]
        ]); 
        
        if(!$url->main){
            return $dataProvider;
        }

        $query->where(['id' => $this->produtSearch->getIdsByIndex(
                    ArrayHelper::map($url->getTerms([$url->main]),'id','id','vid')
                )]);
        
        return $dataProvider;
    }

    /**
     * 
     * @param array $id
     * @return mixed
     */
    public function findById(array $ids){
        return $this->model->find()
                ->where(['id' => $ids]) 
                ->with([
                    'terms',
                    'files',
                    'alias',
                    'groupAlias'  
                ])
                ->all();
    }
    
    public function getMostRatedId(TaxonomyItems $taxonomyItem){
        return $this->produtSearch->getMostRatedId($taxonomyItem);
    }


    public function findCompares(){
        return $this->comparesSeach
                ->find([
                    'session' => $this->_uus->id,
                    'model' => ModelHelper::getModelName($this->model)
                ])
                ->limit($this->module->maxItemsToCompare)
                ->all();
    }
    
    public function getCompareIds(){
        return $this->comparesSeach
                ->ids([
                    'session' => $this->_uus->id,
                    'model' => ModelHelper::getModelName($this->model)
                ])->column();
    }
}
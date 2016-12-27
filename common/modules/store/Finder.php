<?php

namespace common\modules\store;

use Yii;
use yii\base\Object;
use yii\data\ActiveDataProvider;
use common\modules\store\classes\uus\UUS;
use common\modules\store\components\StoreUrlRule;
use common\modules\store\models\product\ProductInterface;
use common\modules\store\models\product\ProductSearch;
use common\modules\store\models\compare\ComparesSearch;
use common\modules\store\models\wish\WishlistSearch;
use common\modules\taxonomy\models\TaxonomyItems;
use common\models\User;

class Finder extends Object{
    
    public $module;
    public $model;
    
    private $_produtSearch;
    private $_comparesSearch;
    private $_wishSearch;
    private $_uus;


    public function __construct(ProductInterface $model = null, ProductSearch $produtSearch, ComparesSearch $comparesSearch, WishlistSearch $wishlistSearch, UUS $uus, $config = array()) {
        $this->_uus = $uus;
        $this->model = $model;
        $this->_produtSearch = $produtSearch;
        if($model){
            $this->_produtSearch->model = $model;
        }
        $this->_comparesSearch = $comparesSearch;
        $this->_wishSearch = $wishlistSearch;
        
        parent::__construct($config);
    }
    
    public function getUus(){
        return $this->_uus;
    }

    public function getProdutSearch(){
        return  $this->_produtSearch;
    }
    
    public function getComparesSearch(){
        return  $this->_comparesSearch;
    }
    
    public function getWishSearch(){
        return  $this->_wishSearch;
    }

    
    /**
     * 
     * @param StoreUrlRule $url
     * @return ActiveDataProvider
     */
    public function search($params = []){
        return $this->_produtSearch->search($params);
    }
    
    /**
     * 
     * @param StoreUrlRule $url
     * @return ActiveDataProvider
     */
    public function searchByUrl(StoreUrlRule $url){
        return $this->_produtSearch->searchByUrl($url, $this->module->defaultPageSize);
    }

    /**
     * 
     * @param int $id
     * @return mixed
     */
    public function getProductById($id){
        return current($this->getProductsByIds([$id]));
    }
    
    /**
     * 
     * @param array $ids
     * @return mixed
     */
    public function getProductsByIds(array $ids){
        return $this->_produtSearch->getProductsByIds($ids);
    }
    
    /**
     * 
     * @param string|array $groups
     * @return [] mixed
     */
    public function getProductsByGroup($groups){
        return $this->getProductsByIds($this->_produtSearch->getProductIdsByGroup($groups));
    }
    
    /**
     * 
     * @param TaxonomyItems $taxonomyItem
     * @return type
     */
    public function getMostRatedId(TaxonomyItems $taxonomyItem){
        return $this->_produtSearch->getMostRatedId($taxonomyItem);
    }
    
    
    public function getWishItems(User $user){
        return $this->_wishSearch->getItems($this->_wishSearch->getIds($user));
    }
    
    public function getCompareItems(ProductInterface $entity = null){
        return $this->_comparesSearch->getItems($this->_comparesSearch->getIds($entity));
    }
}
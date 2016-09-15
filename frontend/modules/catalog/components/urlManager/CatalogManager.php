<?php

namespace frontend\modules\catalog\components\urlManager;

use Yii;
use frontend\modules\catalog\components\FilterParams;
use common\modules\taxonomy\models\TaxonomyItems;
use frontend\modules\catalog\components\urlManager\FilterManager;
use yii\helpers\ArrayHelper;

class CatalogManager{
    
    private $filter;
    private $vocabularyId;

    public function __construct() {
        $this->vocabularyId = Yii::$app->params['catalog']['vocabularyId'];
    }
    
    public function setFilter(FilterParams $filter){
        $this->filter = $filter;
    }
    
    /**
     * 
     * @return string
     */
    public function getUrl(){
        return $this->filter->catalogUrl;
    }
    
    /**
     * 
     * @param TaxonomyItems $term
     * @return \frontend\modules\catalog\components\urlManager\FilterManager
     */
    public function pull(TaxonomyItems $term){
        $menu = explode('/', $this->filter->catalogUrl);
        if(($index = array_search($term->transliteration, $menu)) !== false){
            unset($menu[$index]);
        }
        $this->filter->catalogUrl = implode('/', $menu);
        return $this;
    }
    
    
    /**
     * 
     * @param string $pathInfo
     * @return boolean || []
     */
    public function parseUrl($pathInfo){
        $params = array_filter(explode('/', $pathInfo));
        if(empty($params)){
            return false;
        }
        
        if(($index = array_search(FilterManager::FILTER_INDICATOR, $params)) !== false){
            $params = array_slice($params, 0, $index);
        } 
        
        $terms = TaxonomyItems::find()
                ->where([
                    'transliteration' => $params,
                ])->all();
        
        
        if(!$terms || count($terms) != count($params)){
            return false;
        }
        $this->filter->catalogUrl = implode('/',$params);
        return ArrayHelper::index($terms, 'id', 'vid');
    }
}
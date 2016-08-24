<?php
namespace frontend\modules\catalog\components;

use Yii;
use yii\web\UrlRule;
use yii\helpers\ArrayHelper;
use frontend\modules\catalog\helpers\CatalogHelper;
use frontend\modules\catalog\components\FilterParams;
use frontend\modules\catalog\helpers\FilterHelper;
use common\modules\taxonomy\models\TaxonomyItems;

class CatalogUrlRule extends UrlRule {

    private $filterParams;
    private $catalogVocabularyId;

    public function init() {
        if ($this->name === null) {
                $this->name = __CLASS__;
        }
        $this->filterParams = FilterParams::getInstance();
        $this->catalogVocabularyId = Yii::$app->params['catalog']['vocabularyId'];
    }

    /**
     * @inheritdoc
     */ 
    public function createUrl($manager, $route, $params) {
        
        if($route == 'filter' & isset($params['term']) && $params['term'] instanceof TaxonomyItems){
            $filter = clone $this->filterParams;
            if(FilterHelper::clearIndex($filter, $params['term']) === false){
                FilterHelper::addIndex($filter, $params['term']);
            }
            FilterHelper::clearIndexByTransliteration($filter, explode('/', $filter->catalogUrl));
            $link = FilterHelper::getFilterString($filter);
            return ($query = http_build_query($params)) ? $link . '?' . $query : $link;
        }
        
        if($route == 'catalog' & isset($params['term']) && $params['term'] instanceof TaxonomyItems ){
            $menu = explode('/', $this->filterParams->catalogUrl);
            if(($index = array_search($params['term']->transliteration, $menu)) !== false){
                 unset($menu[$index]);
            }
            return implode('/', $menu);
        }
        
        if($route == 'catalog' & isset($params['menu'])){
            $menu = [];
            foreach($params['menu'] as $item){
                $menu[] = $item['transliteration'];
            }
            return implode('/', $menu);
        }

        
        return false; 
    }
    
    /**
     * @inheritdoc
     */
    public function parseRequest($manager, $request) {
   
        if($this->parseUrl($request->getPathInfo()) === false){
            return false;
        }  
        $params = [
            'filter' => FilterParams::getInstance()
        ]; 
        return ['catalog/default/index', $params];
    }
    
    /**
     * 
     * @param string $pathInfo
     * @return []
     */
    public function parseUrl($pathInfo){
    
        if($this->filterParams->index !== false)
        {
            return $this->filterParams->index;
        }
        
        $paramsCatalog = $this->parseCatalogUrl($pathInfo);
        if($paramsCatalog === false){
            return false;
        }
        
        foreach($paramsCatalog as $vocabularyId => $terms){
            foreach($terms as $term){
                FilterHelper::addIndex($this->filterParams, $term);
            }
        }
        
        $paramsFilter = $this->parseFilterUrlParams($pathInfo);
        
        if($paramsFilter){
            foreach($paramsFilter['index'] as $term){
                FilterHelper::addIndex($this->filterParams, $term);
            }
           
            $this->filterParams->priceMin = $paramsFilter['priceMin'];
            $this->filterParams->priceMax = $paramsFilter['priceMax'];
        }
        return $this->filterParams;
    }

    /**
     * 
     * @param string $pathInfo
     * @param array $prefixes
     * @return boolean || []
     */
    private function parseFilterUrlParams($pathInfo){
        
        $chunks = explode('/', $pathInfo);
        
        if(count($chunks) < 3){
            return false;
        }
       
        $filterString = array_pop($chunks);
        if(array_pop($chunks) != FilterHelper::FILTER_INDICATOR){
            return false;
        }
        $data = explode('_', $filterString);
        $index = [];
        $price = [
                'priceMax' => null,
                'priceMin' => null
        ];
        
        foreach($data as $item){

            if(($param = $this->isPriceParam($item)) !== false){
                $price = $param;
            }
            
            else
                
            if(($param = $this->isTermIdParam($item, $this->filterParams->prefixes)) !== false){
                $index = CatalogHelper::merge($index, $param);
            }
            
            else
            
            if(($param = $this->isNamedParam($item, $this->filterParams->prefixes)) !== false){
                $index = CatalogHelper::merge($index, $param);
            }
            
            else     
            
            if(($param = $this->isTermParam($item)) !== false){
                $index = CatalogHelper::merge($index, $param);
            }
            
            else{
                return false;
            }
        }
        
        return array_merge(['index' => $index], $price);
    }
    
    /**
     * 
     * @param string $pathInfo
     * @return boolean || []
     */
    private function parseCatalogUrl($pathInfo){
  
        if($pathInfo == ''){
            return false;
        }
        
        $params = array_filter(explode('/', $pathInfo));

        if(empty($params)){
            return false;
        }
        
        if(($index = array_search('filter', $params)) !== false){
            $params = array_slice($params, 0, $index);
        } 
        
        $terms = TaxonomyItems::find()
                ->where([
                    'transliteration' => $params,
                ])
                ->orderBy([
                        'weight' => SORT_ASC
                ])
                ->all();
        
        
        if(!$terms || count($terms) != count($params)){
            return false;
        }

        $this->filterParams->catalogUrl = implode('/',$params);

        $return = [];
        foreach($terms as $term){
            $return[$term->vid][$term->id] = $term;
        }
        return $return;
    }

    /**
     * 
     * @param type $param
     * @return boolean
     */
    private function isPriceParam($param){
        $param = explode('-', $param);
        if(count($param) < 3 || $param[0] != FilterHelper::PRICE_PREFIX){
            return false;
        }
        return [
            'priceMin' => $param[1],
            'priceMax' => $param[2]
        ];
    }


    /**
     * 
     * @param string $transliteration
     * @return boolean || []
     */
    private function isTermParam($transliteration){
        $term = TaxonomyItems::find()->where(['transliteration' => $transliteration])->one();
        if(!$term){
            return false;
        }
        return [$term->vid => $term];
    }

    /**
     * 
     * @param string $param
     * @param array $prefixes
     * @return boolean || []
     */
    private function isTermIdParam($param, array $prefixes){
        $param = explode('-', $param);
        if(count($param) < 2){
            return false;
        }
        
        $prefix = array_shift($param);
        $vocabularyId = substr($prefix, 1);

        if(strpos($prefix, FilterHelper::TERM_ID_PREFIX) !== 0 || !isset($prefixes[$vocabularyId]) ){
             return false;
        }

        foreach ($param as $termId) {
            if (!is_numeric($termId)) {
                return false;
            }
        }
        
        return [$vocabularyId => TaxonomyItems::findAll($param)];
    }
    
    /**
     * 
     * @param string $param
     * @param array $prefixes
     * @return boolean || []
     */
    private function isNamedParam($param, array $prefixes){

        foreach($prefixes as $vocabularyId => $prefix){
            
            if(!$prefix){
                continue;
            }
            
            if(strpos($param, $prefix) === 0 && strlen($prefix) < strlen($param)){
                $transliteration =  substr($param, strlen($prefix));
                $term = TaxonomyItems::find()->where([
                    'transliteration' => $transliteration,
                    'vid' => $vocabularyId
                        ])->one();
                if(!$term){
                    return false;
                }
                return [$term->vid => $term];
            }
        }
        return false;
    }
    
}

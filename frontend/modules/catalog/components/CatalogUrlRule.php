<?php
namespace frontend\modules\catalog\components;

use Yii;
use yii\web\UrlRule;
use yii\helpers\ArrayHelper;
use frontend\modules\catalog\helpers\CatalogHelper;
use frontend\modules\catalog\components\FilterParams;
use common\modules\taxonomy\models\TaxonomyVocabularySearch;
use common\modules\taxonomy\models\TaxonomyVocabulary;
use common\modules\taxonomy\models\TaxonomyItems;

class CatalogUrlRule extends UrlRule {

    const TERM_ID_PREFIX = 't';
    const FILTER_INDICATOR = 'filter';


    private $filterParams;

    public function init() {
        if ($this->name === null) {
                $this->name = __CLASS__;
        }
    }

    /**
     * @inheritdoc
     */
    public function createUrl($manager, $route, $params) {
        
            if($route == 'catalog/default/index'){
                $link = isset($params['filter']) && $params['filter'] instanceof TaxonomyItems ? $this->getFilterUrl($params['filter']) : $this->getFilterUrl();
                $query = http_build_query($params);
                return $query ? $link . '?' . $query : $link;
            }
           
            if(isset($params['catalogMenu'])){
                $menu = [];
                foreach($params['catalogMenu'] as $item){
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
 
        if(($filterParams = $this->parseUrl($request->getPathInfo())) === false){
            return false;
        }
        $params = [
            'filter' => FilterParams::getInstance()
        ];
        return ['catalog/default/index', $params];
    }
    
    /**
     * 
     * @param TaxonomyItems $term
     * @return string
     */
    public function getFilterUrl(TaxonomyItems $term = null){
        $this->filterParams = FilterParams::getInstance();
        $filter = $this->filterParams->index;
        $catalogVocabularyId = Yii::$app->params['catalog']['vocabularyId'];
       
        if(isset($filter[$catalogVocabularyId])){
            unset($filter[$catalogVocabularyId]);
        }
        
        if($term !==null && CatalogHelper::clearId($term, $filter) === false){
            CatalogHelper::addId($term, $filter);
        }

        if(($filterUrl = $this->getFilterString($filter))){
            return $this->filterParams->catalogUrl . '/' . self::FILTER_INDICATOR . '/' . $filterUrl;
        }
        return $this->filterParams->catalogUrl;
    }
    
    /**
     * 
     * @param array $filter
     * @return string
     */
    private function getFilterString(array $filter){
        $link = [];
        foreach($this->filterParams->prefixes as $vocabularyId => $prefix){
            
            if(!isset($filter[$vocabularyId])){
                continue;
            }
            
            $value = $filter[$vocabularyId];
            
            if(is_array($value) && count($value) == 1){
                $value = array_shift($value); 
            }
            
            if(is_array($value) && count($value) > 1){
               $link[] = self::TERM_ID_PREFIX . $vocabularyId . '-' . implode('-', ArrayHelper::getColumn($value, 'id')); 
            }else{  
                $link[] = $this->filterParams->prefixes[$value->vid] ? $this->filterParams->prefixes[$value->vid] . $value->transliteration : $value->transliteration; 
            }
        }
        return implode('_', $link);
    }

    /**
     * 
     * @param string $pathInfo
     * @return []
     */
    public function parseUrl($pathInfo){
        $this->filterParams = FilterParams::getInstance();
        if($this->filterParams->index !== false)
        {
            return $this->filterParams->index;
        }
        
        if(($this->filterParams->index = $this->parseFilterParams($pathInfo)) === false){
            $this->filterParams->index = $this->parseCatalogUrl($pathInfo);
        }
        return $this->filterParams->index; 
    }

    /**
     * 
     * @param string $pathInfo
     * @param array $prefixes
     * @return boolean || []
     */
    private function parseFilterParams($pathInfo){

        if(is_null($this->filterParams->prefixes)){
            $this->filterParams->prefixes = TaxonomyVocabularySearch::getPrefixes();
        }
        
        $chunks = explode('/', $pathInfo);
        
        if(count($chunks) < 3){
            return false;
        }
        
        $filterString = array_pop($chunks);
        if(array_pop($chunks) != self::FILTER_INDICATOR){
            return false;
        }
        $data = explode('_', $filterString);
        $params = [];
        foreach($data as $item){

            if(($param = $this->isTermIdParam($item, $this->filterParams->prefixes)) !== false){
                $params = CatalogHelper::merge($params, $param);
            }
  
            else
            
            if(($param = $this->isNamedParam($item, $this->filterParams->prefixes)) !== false){
                $params = CatalogHelper::merge($params, $param);
            }
            
            else     
            
            if(($param = $this->isTermParam($item)) !== false){
                $params = CatalogHelper::merge($params, $param);
            }
            
            else{
                return false;
            }

        }

        $pathInfo = str_replace(self::FILTER_INDICATOR . '/' . $filterString, '', $pathInfo);

        if(($param = $this->parseCatalogUrl($pathInfo)) === false){
            return false;
        }

        return CatalogHelper::merge($params, $param);
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

        $terms = TaxonomyItems::find()
        ->where([
           'vid' => Yii::$app->params['catalog']['vocabularyId'],
           'transliteration' => $params 
        ])        
        ->orderBy([
                'weight' => SORT_ASC
        ])
        ->all();
        

        
        if(!$terms || count($terms) != count($params)){
            return false;
        }
       
        $this->filterParams->catalogUrl = $pathInfo;
        $term = array_pop($terms);
        return [$term->vid => $term];
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

        if(strpos($prefix, self::TERM_ID_PREFIX) !== 0 || !isset($prefixes[$vocabularyId]) ){
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
                $term = TaxonomyItems::find()->where(['transliteration' => $transliteration])->one();
                if(!$term){
                    return false;
                }
                return [$term->vid => $term];
            }
        }
        return false;
    }
    
}

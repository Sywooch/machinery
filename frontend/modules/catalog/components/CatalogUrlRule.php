<?php
namespace frontend\modules\catalog\components;

use Yii;
use yii\web\UrlRule;
use yii\helpers\ArrayHelper;
use frontend\modules\catalog\components\FilterParams;
use common\modules\taxonomy\models\TaxonomyVocabularySearch;
use common\modules\taxonomy\models\TaxonomyVocabulary;
use common\modules\taxonomy\models\TaxonomyItems;

class CatalogUrlRule extends UrlRule {

    const TERM_ID_PREFIX = 't';
    
    private $filterParams;


    public function init() {
        if ($this->name === null) {
                $this->name = __CLASS__;
        }
        
        $this->filterParams = FilterParams::getInstance();
    }

    /**
     * @inheritdoc
     */
    public function createUrl($manager, $route, $params) {
        
            if($route == 'catalog/default/index' && isset($params['filter']) && $params['filter'] instanceof TaxonomyItems){
                return $this->getFilterUrl($params['filter']);
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
            'filter' => $filterParams
        ];
        return ['catalog/default/index', $params];
    }
    
    /**
     * 
     * @param TaxonomyItems $term
     * @return string
     */
    public function getFilterUrl(TaxonomyItems $term){
        
        $filter = $this->filterParams->filter;
        $catalogVocabularyId = Yii::$app->params['catalog']['vocabularyId'];
       
        if(isset($filter[$catalogVocabularyId])){
            unset($filter[$catalogVocabularyId]);
        }
        
        if($this->clearId($term, $filter) === false){
            $this->addId($term, $filter);
        }

        return $this->filterParams->catalogUrl . '/' . $this->getFilterString($filter);
    }
    
    private function getFilterString(array $filter){
        $link = [];
        foreach($filter as $vocabularyId => $value){
            if(is_array($value)){
               $link[] = self::TERM_ID_PREFIX . $vocabularyId . '-' . implode('-', ArrayHelper::getColumn($value, 'id')); 
            }else{  
                $link[] = $this->filterParams->prefixes[$value->vid] ? $this->filterParams->prefixes[$value->vid] . $value->transliteration : $value->transliteration; 
            }
        }
        return implode('_', $link);
    }


    private function addId(TaxonomyItems $term, array &$filter){

        $finded = false;
        
        foreach($filter as $vocabularyId => $value){
            
            if($vocabularyId != $term->vid){
                continue;
            }
            
            $finded = true;
               
            if(is_array($value)){
                $filter[$vocabularyId][] = $term;
            }elseif($value instanceof TaxonomyItems){
                $filter[$vocabularyId] = [$value, $term];
            }
        }
        
        if(!$finded){
            $filter[$term->vid] = $term;
        }
    }
    
    private function clearId(TaxonomyItems $term, array &$filter){

        foreach($filter as $vocabularyId => $value){
            if(is_array($value)){
               $this->clearId($term, $filter[$vocabularyId]);
            }elseif($value instanceof TaxonomyItems && $value->id == $term->id){
                unset($filter[$vocabularyId]);
                return true;
            }
        }
        return false;
    }

    /**
     * 
     * @param string $pathInfo
     * @return []
     */
    public function parseUrl($pathInfo){
        
        if($this->filterParams->filter !== false)
        {
            return $this->filterParams->filter;
        }
        
        if(($this->filterParams->filter = $this->parseFilterParams($pathInfo)) === false){
            $this->filterParams->filter = $this->parseCatalogUrl($pathInfo);
        }
        return $this->filterParams->filter; 
    }

    /**
     * 
     * @param string $pathInfo
     * @param array $prefixes
     * @return boolean || []
     */
    private function parseFilterParams($pathInfo){

        $chunks = explode('/', $pathInfo);
        
        if(count($chunks) <= 2){
            return false;
        }
        
        if(is_null($this->filterParams->prefixes)){
            $this->filterParams->prefixes = TaxonomyVocabularySearch::getPrefixes();
        }

        $filterString = array_pop($chunks);
        $data = explode('_', $filterString);

        $params = [];
        foreach($data as $item){

            if(($param = $this->isTermIdParam($item, $this->filterParams->prefixes)) !== false){
                $params = $this->merge($params, $param);
            }
  
            else
            
            if(($param = $this->isNamedParam($item, $this->filterParams->prefixes)) !== false){
                $params = $this->merge($params, $param);
            }
            
            else     
            
            if(($param = $this->isTermParam($item)) !== false){
                $params = $this->merge($params, $param);
            }
            
            else{
                return false;
            }

        }

        $pathInfo = str_replace($filterString, '', $pathInfo);

        if(($param = $this->parseCatalogUrl($pathInfo)) === false){
            return false;
        }

        return $this->merge($params, $param);
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
     * @param array $params
     * @param array $param
     * @return array
     */
    private function merge(array $params, array $param){
        foreach($param as $key => $value){
            $params[$key] = $value;
        }
        return $params;
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

<?php
namespace frontend\modules\catalog\components;

use Yii;
use yii\web\UrlRule;
use yii\helpers\ArrayHelper;
use frontend\modules\catalog\models\FilterModel;
use frontend\modules\catalog\helpers\CatalogHelper;
use frontend\modules\catalog\components\FilterParams;
use common\modules\taxonomy\models\TaxonomyVocabularySearch;
use common\modules\taxonomy\models\TaxonomyVocabulary;
use common\modules\taxonomy\models\TaxonomyItems;

class CatalogUrlRule extends UrlRule {

    const TERM_ID_PREFIX = 't';
    const FILTER_INDICATOR = 'filter';
    const PRICE_PREFIX = 'prc';

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
            if(isset($params['filter']) && $params['filter'] instanceof TaxonomyItems){
                $link = $this->getFilterUrl($params['filter']);
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
            
            if(isset($params['filter'])){ 
                parse_str(parse_url(Yii::$app->request->url, PHP_URL_QUERY), $query);
                if(isset($params['page'])){
                    $query['page'] = $params['page'];
                }
                if(isset($params['sort'])){
                    $query['sort'] = $params['sort'];
                }
                return Yii::$app->request->pathInfo . '?' . http_build_query($query);
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
     * @param TaxonomyItems $term
     * @return string
     */
    public function getFilterUrl(TaxonomyItems $term = null){
        $this->filterParams = FilterParams::getInstance();
        $catalogVocabularyId = Yii::$app->params['catalog']['vocabularyId'];
       
        $index = $this->filterParams->index;
        if(isset($index[$catalogVocabularyId])){
            unset($index[$catalogVocabularyId]);
        }
        
        if($term !==null && CatalogHelper::clearId($term, $index) === false){
            CatalogHelper::addId($term, $index);
        }

        if(($filterUrl = $this->getFilterString($this->filterParams, $index))){
            $link = [];
            if($this->filterParams->catalogUrl) {
                $link[] = $this->filterParams->catalogUrl;
            }
            $link[] = self::FILTER_INDICATOR ;
            $link[] = $filterUrl ;
            return implode('/', $link);
        }
        return $this->filterParams->catalogUrl;
    }
    
    /**
     * 
     * @param FilterModel $model
     * @return string
     */
    public function getFilterUrlByModel(FilterModel $model){
            $this->filterParams = FilterParams::getInstance();
            $this->filterParams->priceMax = $model->priceMax;
            $this->filterParams->priceMin = $model->priceMin;
            $termIds = array_keys(array_filter($model->index));
            $terms = TaxonomyItems::findAll($termIds);
           
            if(!$terms){
                return '';
            }
            
            $terms = ArrayHelper::index($terms, 'id', 'vid');
            
            if(($filterUrl = $this->getFilterString($this->filterParams, $terms))){
                $link = [];
                if($this->filterParams->catalogUrl) {
                    $link[] = $this->filterParams->catalogUrl;
                }
                $link[] = self::FILTER_INDICATOR ;
                $link[] = $filterUrl ;
                return implode('/', $link);
            }
            
            return $this->filterParams->catalogUrl;
    }


    /**
     * 
     * @param array $filter
     * @return string
     */
    private function getFilterString(FilterParams $filter, $newIndex){
        $link = [];
        foreach($filter->prefixes as $vocabularyId => $prefix){
            
            if(!isset($newIndex[$vocabularyId])){
                continue;
            }

            $value = $newIndex[$vocabularyId];
            
            if(is_array($value) && count($value) == 1){
                $value = array_shift($value); 
            }
            
            if(is_array($value) && count($value) > 1){
               $link[] = self::TERM_ID_PREFIX . $vocabularyId . '-' . implode('-', ArrayHelper::getColumn($value, 'id')); 
            }elseif($value instanceof TaxonomyItems){  
                $link[] = $filter->prefixes[$value->vid] ? $filter->prefixes[$value->vid] . $value->transliteration : $value->transliteration; 
            }
        }
        if($filter->priceMin && $filter->priceMax){
            $link[] = self::PRICE_PREFIX . '-'.implode('-',[$filter->priceMin,$filter->priceMax]);
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
        
        if(($paramsUrl = $this->parseCatalogUrl($pathInfo)) !== false){
            if(($paramsFilter = $this->parseFilterUrlParams($pathInfo))){
                $paramsUrl = CatalogHelper::merge($paramsUrl, $paramsFilter);
            }
        }else{
            return false;
        }
        
        foreach($paramsUrl as $index => $item){
            if(!is_numeric($index)){
                $this->filterParams->{$index} = $item;
                unset($paramsUrl[$index]);
            }
        }
        $this->filterParams->index = $paramsUrl;
        
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
        if(array_pop($chunks) != self::FILTER_INDICATOR){
            return false;
        }
        $data = explode('_', $filterString);
        $params = [];
        foreach($data as $item){

            if(($param = $this->isPriceParam($item)) !== false){
                $params = CatalogHelper::merge($params, $param);
            }
            
            else
                
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
        
        return $params;
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
        
        $termsData = [];
        foreach($params as $index =>  $item){
            $termsData[$index] = [
                        'vid' => null,
                        'transliteration' => $item
                    ];
            foreach($this->filterParams->prefixes as $vocabularyId => $prefix){
                if($prefix && strpos($item, $prefix) === 0 && (int)str_replace($prefix, '', $item)){
                    $termsData[$index] = [
                        'vid' => $vocabularyId,
                        'transliteration' => str_replace($prefix, '', $item)
                    ];
                    unset($params[$index]);
                }
            }  
        }

        $terms = TaxonomyItems::find();
        foreach($termsData as $data){
            $terms->orFilterWhere([
                'transliteration' => $data['transliteration'],
                'vid' => $data['vid']
             ]);
        }
        $terms = $terms->orderBy([
                'weight' => SORT_ASC
        ])
        ->all();
        
        if(!$terms || count($terms) != count($termsData)){
            return false;
        }

        $this->filterParams->catalogUrl = implode('/',$params);

        $return = [];
        foreach($terms as $term){
            $return[$term->vid][] = $term;
        }
        return $return;
    }

    private function isPriceParam($param){
        $param = explode('-', $param);
        if(count($param) < 3 || $param[0] != self::PRICE_PREFIX){
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

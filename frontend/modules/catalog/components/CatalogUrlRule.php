<?php
namespace frontend\modules\catalog\components;

use yii\web\UrlRule;
use frontend\modules\catalog\components\FilterParams;
use common\modules\taxonomy\models\TaxonomyItems;
use frontend\modules\catalog\components\urlManager\Url;

class CatalogUrlRule extends UrlRule {

    private $url;

    public function init() {
        if ($this->name === null) {
                $this->name = __CLASS__;
        }
        $this->url = new Url();  
    }

    /**
     * @inheritdoc
     */ 
    public function createUrl($manager, $route, $params) {
        
        if($route == 'filter' & isset($params['term']) && $params['term'] instanceof TaxonomyItems){
            $this->url->setFilterInstance(clone FilterParams::getInstance());
            $link = $this->url->filter->pull($params['term'])->getUrl();
            return ($query = http_build_query($params)) ? $link . '?' . $query : $link;
        }
        
        if($route == 'catalog' & isset($params['term']) && $params['term'] instanceof TaxonomyItems ){
            $this->url->setFilterInstance(clone FilterParams::getInstance());
            return $this->url->catalog->pull($params['term'])->getUrl();
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
        if($this->url->parseUrl($request->getPathInfo()) === false){
            return false;
        }  
        $params = [
            'filter' => FilterParams::getInstance()
        ]; 
        return ['catalog/default/index', $params];
    }
}

<?php
namespace frontend\modules\catalog\components;

use Yii;
use yii\web\UrlRule;
use common\modules\taxonomy\models\TaxonomyVocabularySearch;
use common\modules\taxonomy\models\TaxonomyItems;
use frontend\modules\catalog\helpers\UrlHelper;

class CatalogUrlRule extends UrlRule {

    private $urlHelper;
    
    public function __construct(UrlHelper $urlHelper) {
        $this->urlHelper = $urlHelper;
    }
    
    public function init() {
            if ($this->name === null) {
                    $this->name = __CLASS__;
            }
    }

    public function createUrl($manager, $route, $params) {
            if(!isset($params['catalogMenu'])){
                return false;
            }
            $menu = [];
            foreach($params['catalogMenu'] as $item){
                $menu[] = $item['transliteration'];
            }
            return implode('/', $menu);  
    }

    public function parseRequest($manager, $request) {

        $pathInfo = $request->getPathInfo();

        if(($filterParams = $this->urlHelper->parseUrlParams($pathInfo, TaxonomyVocabularySearch::getPrefixes())) === false){
            $filterParams = $this->urlHelper->isCatalogUrl($pathInfo);
        }
        
        if(!$filterParams){
            return false;
        }
        
        $params = [
            'filter' => $filterParams
        ];
        return ['catalog/default/index', $params];
    }

}

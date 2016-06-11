<?php
namespace frontend\modules\product\components;

use yii\web\UrlRule;
use frontend\modules\catalog\helpers\CatalogHelper;
use common\modules\taxonomy\models\TaxonomyItems;

class ProductUrlRule extends UrlRule {

    public function init() {
		if ($this->name === null) {
			$this->name = __CLASS__;
		}
	}

	public function createUrl($manager, $route, $params) {
            if($route == 'product' && isset($params['entity'])){
                if(($catalogId = CatalogHelper::getCatalogIdByModel($params['entity'])) === false){
                    return false;    
                }
                $url = [
                   \URLify::filter($params['entity']->title),
                   'p'.$catalogId.'_'.$params['entity']->id
                ];
               return implode('-',$url);
            }
            return false;  
	}

	public function parseRequest($manager, $request) {
  
            $matches = [];
            $pathInfo = $request->getPathInfo();           
            if(!preg_match ("/.+p(\d+)_(\d+)/i", $pathInfo, $matches)){
                return false;
            }
            $term = TaxonomyItems::findOne($matches[1]);
            if(!$term){
                return false;
            }
            
            $params = [
                'catalogId' => $term->id,
                'productId' => $matches[2],
                'ProductSearch' => [
                    'id' => $matches[2],
                    'index' => [
                        $term->id
                    ]
                ]
            ];
            return ['product/default/index', $params];
	}

}

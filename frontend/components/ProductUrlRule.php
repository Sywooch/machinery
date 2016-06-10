<?php

namespace frontend\components;

use Yii;
use yii\web\UrlRule;
use common\modules\taxonomy\models\TaxonomyItems;

class ProductUrlRule extends UrlRule {

    public function init() {
		if ($this->name === null) {
			$this->name = __CLASS__;
		}
	}

	public function createUrl($manager, $route, $params) {
		return false;  // this rule does not apply
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
                'ProductSearch' => [
                    'id' => $matches[2],
                    'index' => [
                        $term->id
                    ]
                ]
            ];
            return ['product/index', $params];
	}

}

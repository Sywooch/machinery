<?php
namespace frontend\modules\catalog\components;

use Yii;
use yii\web\UrlRule;
use common\modules\taxonomy\models\TaxonomyItems;

class CatalogUrlRule extends UrlRule {

    public function init() {
		if ($this->name === null) {
			$this->name = __CLASS__;
		}
	}

	public function createUrl($manager, $route, $params) {
		return false;  // this rule does not apply
	}

	public function parseRequest($manager, $request) {
            $root = '';
            $pathInfo = $request->getPathInfo();
            $chunks = explode('/', $pathInfo);

            if(!is_array($chunks)){
                $root = $chunks;
            }else{
                $root = array_shift($chunks);
            }

            $term = TaxonomyItems::findOne([
                'vid' => Yii::$app->params['catalog']['vocabularyId'],
                'transliteration' => \URLify::filter ($root, 60, "", true)
            ]);

            if(!$term){
                return false;
            }

            $catalogId = $term->pid ? $term->pid : $term->id;
            $params = [
                'catalogId' => $catalogId,
                'ProductSearch' => [
                    'index' => [
                        $catalogId
                    ]
                ]
            ];
            return ['catalog/default/index', $params];
	}

}

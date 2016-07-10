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
            
            
            \URLify::add_chars (array (',' => '.', '_' => '-' ));

            
            $root = '';
            $pathInfo = $request->getPathInfo();
            $chunks = explode('/', $pathInfo);
           
            foreach($chunks as $index => $item){
                $chunks[$index] = \URLify::filter (\URLify::downcode ($item), 60, "", true);
            }
            
            $terms = TaxonomyItems::find()
            ->where([
               'vid' => Yii::$app->params['catalog']['vocabularyId'],
                'transliteration' => $chunks 
            ])        
            ->orderBy([
                    'weight' => SORT_ASC
            ])
            ->all();
            
            if(!$terms || count($terms) != count($chunks)){
                return false;
            }
            
            $term = array_pop($terms);
            
            $params = [
                'catalogId' => $term->id,
                'ProductSearch' => [
                    'index' => [
                        $term->id
                    ]
                ]
            ];
            return ['catalog/default/index', $params];
	}

}

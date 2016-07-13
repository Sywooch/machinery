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

        \URLify::add_chars (array (',' => '.', '_' => '-' ));

        $root = '';
        $pathInfo = $request->getPathInfo();
        $chunks = explode('/', $pathInfo);

        if(($filterParams = $this->urlHelper->parseUrlParams($chunks, TaxonomyVocabularySearch::getPrefixes())) != false){
            array_pop($chunks);
        }

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
        $filterParams[] = $term->id;
        $params = [
            'catalogId' => $term->id,
            'ProductSearch' => [
                'index' => $filterParams
            ]
        ];
        return ['catalog/default/index', $params];
    }

}

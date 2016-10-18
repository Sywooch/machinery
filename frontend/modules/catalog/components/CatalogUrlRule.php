<?php
namespace frontend\modules\catalog\components;

use Yii;
use yii\web\UrlRule;
use frontend\modules\catalog\components\FilterParams;
use common\modules\taxonomy\models\TaxonomyItems;
use frontend\modules\catalog\components\Url;

class CatalogUrlRule extends UrlRule {

    public function init() {
        if ($this->name === null) {
                $this->name = __CLASS__;
        }
    }

    /**
     * @inheritdoc
     */ 
    public function createUrl($manager, $route, $params) {        
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
        
        Yii::$app->url->path = $request->getPathInfo();

        if( Yii::$app->url->validate()){
            $params = [
                'filter' => Yii::$app->url
            ]; 
            return ['catalog/default/index', $params];
        }  
        
        return false;
        
    }
}

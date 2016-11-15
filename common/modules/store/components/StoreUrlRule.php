<?php
namespace common\modules\store\components;

use Yii;
use common\modules\store\classes\Url;
use yii\web\UrlRuleInterface;
use yii\base\Object;

class StoreUrlRule extends Url implements UrlRuleInterface {

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
        
        $this->path = $request->getPathInfo();

        if($this->validate()){
            $params = [
                'url' => $this
            ]; 
            
            if($this->category){
                return ['store/default/index', $params];
            }
            
            return ['store/default/sub-categories', $params];
        }  
        
        return false;
    }
}

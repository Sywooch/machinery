<?php
namespace frontend\modules\product\components;

use Yii;
use yii\web\UrlRule;
use frontend\modules\catalog\components\FilterParams;
use common\models\Alias;

class ProductUrlRule extends UrlRule {

    public $map = [
        'otzyvy'
    ];

    public function init() {
        if ($this->name === null) {
                $this->name = __CLASS__;
        }
    }
    
    /**
     * @inheritdoc
     */
    public function createUrl($manager, $route, $params) {
           
            return false; 
    }
    
    /**
     * @inheritdoc
     */
    public function parseRequest($manager, $request) {
   
        $url = explode('/', $request->getPathInfo());
        $tab = array_pop($url);
        if(empty($url) || !in_array($tab, $this->map)){
            return false;
        }
        $alias = Alias::find()->where(['alias' => implode('/', $url)])->one();
        if(!$alias){
            return false;
        }
        $url = parse_url ( $alias->url);
        parse_str ( $url['query'], $query );
        $query['tab'] = $tab;
        return [str_replace('group', $tab, $url['path']), $query];
    }
    
    
    
}

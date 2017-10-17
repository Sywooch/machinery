<?php
namespace frontend\components;

use Yii;
use yii\web\UrlRule;
use common\models\Alias;

class AliasRule extends UrlRule {


    public function init() {
        if ($this->name === null) {
                $this->name = __CLASS__;
        }
    }

    /**
     * @inheritdoc
     */
    public function createUrl($manager, $route, $params) {
        ksort($params);
        $query = http_build_query($params);
        if ($query)
            $route .= "?" . $query;

        $data = Yii::$app->db->createCommand('SELECT * FROM {{alias}} WHERE url =:url ', [
            ':url' => $route,
        ])->queryOne();

        if ($data) {
            return $data['alias'];
        }
        return false;
    }
    
    /**
     * @inheritdoc
     */
    public function parseRequest($manager, $request) {
        
        if(($return = $this->parseAliasUrl()) !== false){
            return $return;
        }
        
        return false;
    }
    private function parseAliasUrl(){
        $alias = Alias::find()->where(['alias' => Yii::$app->request->pathInfo])->one();
        if(!$alias){
            return false;
        }
        $url = parse_url ( $alias->url);
        parse_str ( $url['query'], $query );
        return [$url['path'], $query];
    }
}

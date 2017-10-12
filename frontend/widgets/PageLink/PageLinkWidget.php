<?php
namespace frontend\widgets\PageLink;

use Yii;

use backend\models\Pages;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class PageLinkWidget extends \yii\bootstrap\Widget
{
    public $id;
    public $lang = null;
    
    public function __construct($config = array()) {
        parent::__construct($config);
    }
    
    public function run()
    {
        $lang = $this->lang ?? \Yii::$app->language;
        if(!$model = Pages::find()->where(['parent'=>$this->id])->all())
            return false;
        $pagesLang = ArrayHelper::index($model, 'lang', null);
        $pagesId = ArrayHelper::index($model, 'id', null);
        $page = $pagesLang[$lang] ?? $pagesId[$this->id];
        $requestUrl = \Yii::$app->request->url;
        $url = Url::to(['pages/view', 'id'=>$page->id]);
        $params = [];
        if($url == $requestUrl)
            $params['class'] = 'active';
        return Html::a($page->title, $url, $params);
    }
}

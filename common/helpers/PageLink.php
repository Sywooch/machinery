<?php

namespace common\helpers;

use backend\models\Pages;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
class PageLink
{

    public static function a($id, $lang=null)
    {
        $lang = $lang ?? \Yii::$app->language;
        if(!$model = Pages::find()->where(['parent'=>$id])->with('alias')->asArray()->all()) return false;
        $pagesLang = ArrayHelper::index($model, 'lang', null);
        $pagesId = ArrayHelper::index($model, 'id', null);
        $page = $pagesLang[$lang] ?? $pagesId[$id];
        $requestUrl = \Yii::$app->request->url;
        $url = Url::to(['pages/view', 'id'=>$page['id']]);
        $params = [];
        if($url == $requestUrl)
            $params['class'] = 'active';
        return Html::a($page['title'], $url, $params);
        dd($pagesId);
    }

}
<?php
namespace frontend\widgets\CurrencySwitch;

use Yii;

use common\models\Currency;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class CurrencySwitchWidget extends \yii\bootstrap\Widget
{
    
    public function __construct($config = array()) {
        parent::__construct($config);
    }
    
    public function run()
    {
        $cookies = Yii::$app->request->cookies;
        $model = Currency::find()
            ->where(['active'=>'1'])
            ->select(['code', 'name', 'course', 'default'])
            ->orderBy(['weigth'=>'asc'])
            ->indexBy('code')
            ->asArray()
            ->all();

        $default = array_filter($model, function($var){
            return $var['default'];
        });
        $default = array_shift($default);
        $activeCurrency = $cookies->getValue('active_currency', $default['code']);

        return $this->render('switch', ['model'=>$model, 'activeCurrency'=>$activeCurrency]);
    }
}

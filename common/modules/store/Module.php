<?php

namespace common\modules\store;

use Yii;
use common\modules\store\Finder;
use common\modules\store\components\Url;
use common\modules\store\models\ProductSearch;

class Module extends \yii\base\Module
{
    public $defaultPageSize = 20;
    public $buyButtonText = 'Купить';
    public $maxItemsToCompare = 100;
    public $maxItemsToWish = 100;
    public $models;

    public function init()
    {
        Yii::$container->setSingleton(Finder::class,[
            'module' => $this,
        ]);
        parent::init();
    }

}

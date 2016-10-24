<?php
namespace frontend\modules\catalog\widgets\Compare;

use Yii;
use common\modules\taxonomy\models\TaxonomyItemsSearch;
use common\modules\taxonomy\helpers\TaxonomyHelper;
use yii\base\InvalidParamException;

class CompareWidget extends \yii\bootstrap\Widget
{

    
    
    public function run()
    {
        return $this->render('compare-widget');
    }
}

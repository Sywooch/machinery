<?php
namespace common\modules\store\widgets\PromoCode;

use Yii;
use common\modules\store\models\promo\PromoCodes;

class PromoCodeWidget extends \yii\bootstrap\Widget
{

    public function __construct($config = []) {
        parent::__construct($config);
    }
    
    public function run()
    {
        $model = new PromoCodes();
        $model->scenario = PromoCodes::SCENARIO_FIND;
        return $this->render('_form', [
                'model' => $model,
        ]);
    }
}

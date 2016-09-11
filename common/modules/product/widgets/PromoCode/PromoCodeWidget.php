<?php
namespace common\modules\product\widgets\PromoCode;

use Yii;
use common\modules\product\models\PromoCodes;

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

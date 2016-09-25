<?php
namespace common\modules\orders\widgets\PromoCode;

use Yii;
use common\modules\orders\models\PromoCodes;

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

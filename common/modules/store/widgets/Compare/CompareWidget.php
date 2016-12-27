<?php
namespace common\modules\store\widgets\Compare;

use Yii;
use common\modules\store\models\compare\ComparesSearch;

class CompareWidget extends \yii\bootstrap\Widget
{
    private $_model;
    
    public function __construct(ComparesSearch $model, $config = array()) {
        $this->_model = $model;
        parent::__construct($config);
    }
    public function run()
    {
        return $this->render('compare-widget',['count' => $this->_model->count]);
    }
}

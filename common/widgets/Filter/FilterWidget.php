<?php
namespace common\widgets\Filter;

use Yii;
use yii\bootstrap\Widget;



class FilterWidget extends Widget
{
    const CACHE_TIME = 60 * 60 * 5;

    private $_model;

    public function __construct($config = array())
    {
        
        parent::__construct($config);
    }
    
    public function run()
    {
        // $this->_model->load(Yii::$app->request->get());

        return $this->render('filter-widget', [
            // 'model' => $this->_model,
        ]);
    }

}

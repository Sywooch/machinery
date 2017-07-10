<?php 

namespace common\widgets\Adminmenu;

use Yii;
use yii\bootstrap\Widget;


class AdminmenuWidget  extends Widget
{
    
    private $_model;

    public function __construct($config = array())
    {
        
        parent::__construct($config);
    }
    
    public function run()
    {
        // $this->_model->load(Yii::$app->request->get());

        return $this->render('sidebar', [
            // 'model' => $this->_model,
        ]);
    }

}

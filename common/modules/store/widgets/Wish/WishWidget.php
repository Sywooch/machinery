<?php
namespace common\modules\store\widgets\Wish;

use common\modules\store\models\wish\WishlistSearch;

class WishWidget extends \yii\bootstrap\Widget
{

    private $_model;
    
    public function __construct(WishlistSearch $model, $config = array()) {
        $this->_model = $model;
        parent::__construct($config);
    }
    
    public function run()
    {
        return $this->render('wish-widget', ['count' => $this->_model->count]);
    }
}

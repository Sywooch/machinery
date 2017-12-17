<?php

namespace common\modules\communion\widgets;

use Yii;
use yii\bootstrap\Widget;

class CommunionWidget extends Widget
{
    private $_model;

    public function __construct($config = array())
    {

        parent::__construct($config);
    }

    public function run()
    {
        return $this->render('sidebar', [
            // 'model' => $this->_model,
        ]);
    }
}
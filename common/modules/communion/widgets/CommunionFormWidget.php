<?php

namespace common\modules\communion\widgets;

use Yii;
use yii\bootstrap\Widget;
use common\modules\communion\models\CommunionMessage;
use common\modules\communion\models\Communion;

class CommunionFormWidget extends Widget
{
    private $_model;
    private $_communion;

    public $subject;
    public $user_to;

    public function __construct($config = array())
    {
//        $this->_model = $message;
        parent::__construct($config);
    }

    public function run()
    {
        $this->_communion = new Communion();
        return $this->render('form-message', [
            'model' => new CommunionMessage,
            'communion' => new Communion(),
            'subject' => $this->subject,
            'user_to' => $this->user_to,
        ]);
    }
}
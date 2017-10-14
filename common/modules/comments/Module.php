<?php

namespace common\modules\comments;

class Module extends \yii\base\Module
{

    /**
     * @var int
     */
    public $maxThread = 3;

    public function init()
    {
        parent::init();
    }
}

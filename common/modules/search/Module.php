<?php

namespace common\modules\search;

use yii;

class Module extends \yii\base\Module
{
    /**
     * @var string
     */
    public $driver;

    /**
     * @var array
     */
    public $models = [];

    /**
     * @var
     */
    protected $search;

    public function init()
    {
        $this->search = Yii::$container->get($this->driver, [], ['module' => $this]);
        parent::init();
    }

    /**
     * @return mixed
     */
    public function getSearch()
    {
        return $this->search;
    }
}

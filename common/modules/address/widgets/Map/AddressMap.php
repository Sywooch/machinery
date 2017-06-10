<?php

namespace common\modules\address\widgets\Map;

use yii;
use yii\base\Widget;

class AddressMap extends Widget {


    /**
     * @var bool
     */
    public $static = false;

    /**
     * @var mixed
     */
    public $address;

    /**
     * @var string
     */
    public $size = [];

    /**
     * @var int
     */
    private static $fieldId = -1;

    public function run() {

        self::$fieldId++;

        if ($this->static == false) {
            return $this->render('map', [
                'address' => $this->address,
                'fieldId' => self::$fieldId
            ]);
        }


        return $this->render('static', [
            'address' => $this->address,
            'size' => $this->size
        ]);

    }

}

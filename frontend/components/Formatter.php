<?php

namespace frontend\components;

use yii\i18n\Formatter as BaseFormater;
use NumberFormatter;


class Formatter extends BaseFormater{
    
    private $_intlLoaded;


    public function init(){
        parent::init();
    }

    /**
     * @param mixed $value
     * @param null $currency
     * @param array $options
     * @param array $textOptions
     * @return string
     */
    public function asCurrency($value, $currency = null, $options = [], $textOptions = [])
    {
        if ($value === null) {
            return $this->nullDisplay;
        }

        $value = $this->normalizeNumericValue($value);

        return number_format($value, 0, '',' ') . ' <span>грн</span>';

    }

    /**
     * @param $value
     * @return mixed
     */
    public function asPhone($value){
        return $value;
    }
    
}

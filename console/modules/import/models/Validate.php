<?php

namespace console\modules\import\models;

use Yii;

/**
*
 */
class Validate extends \yii\base\Model
{
    public $sku;
    public $name;
    public $description;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sku', 'name'], 'required'],
            [['description'], 'string'],
            [['sku'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 255],
        ];
    }

}

<?php

namespace common\modules\import\models;

use Yii;
/**
*
 */
class ImportImages extends \yii\base\Model
{
    const TABLE_IMPORT_IMAGES = 'import_images';
    
    public $sku;
    public $entity_id;
    public $model;
    public $url;
    public $status;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sku', 'entity_id', 'model', 'url'], 'required'],
            [['entity_id'], 'integer'],
            [['sku'], 'string', 'max' => 20],
            [['model'], 'string', 'max' => 50],
            [['url'], 'string', 'max' => 255],
            [['status'], 'boolean'],
        ];
    }
    
}

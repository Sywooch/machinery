<?php

namespace common\modules\file\models;

use Yii;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use common\helpers\ModelHelper;

/**
 * This is the model class for table "files".
 *
 * @property integer $id
 * @property integer $entity_id
 * @property string $field
 * @property string $model
 * @property string $filename
 * @property string $path
 * @property string $size
 * @property string $mimetype
 * @property integer $delta
 */
class File extends \yii\db\ActiveRecord
{
    
    const TABLE_FILES = 'files';
   
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return self::TABLE_FILES;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entity_id', 'field', 'model', 'name', 'path'], 'required'],
            [['entity_id', 'size', 'delta'], 'integer'],
            [['field', 'model'], 'string', 'max' => 50],
            [['name', 'path'], 'string', 'max' => 255],
            [['mimetype'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'entity_id' => 'Entity ID',
            'field' => 'Field',
            'model' => 'Model',
            'name' => 'Filename',
            'path' => 'Path',
            'size' => 'Size',
            'mimetype' => 'Mimetype',
            'delta' => 'Delta',
        ];
    }

}

<?php

namespace common\modules\store\models;

use Yii;

/**
 * This is the model class for table "wishlist".
 *
 * @property integer $id
 * @property integer $entity_id
 * @property string $model
 * @property integer $user_id
 */
class Wishlist extends \yii\db\ActiveRecord
{
    const MAX_ITEMS_WISH = 500;
            
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wishlist';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entity_id', 'model', 'user_id'], 'required'],
            [['entity_id', 'user_id'], 'integer'],
            [['model'], 'string', 'max' => 50],
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
            'model' => 'Model',
            'user_id' => 'User ID',
        ];
    }
    
}

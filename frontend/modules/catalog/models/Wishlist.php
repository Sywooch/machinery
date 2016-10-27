<?php

namespace frontend\modules\catalog\models;

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
    
    public static function getItems($userId = null){
        return self::find()->where([
                'user_id' => $userId ? $userId : Yii::$app->user->id
             ])
            ->limit(self::MAX_ITEMS_WISH)
            ->all();
    }
    
    public static function getCount(){
        return (new \yii\db\Query())->select('COUNT(id)')
                ->from(self::tableName())
                ->where([
                    'user_id' => \Yii::$app->user->id
                ])
                ->count();
    }
    
}

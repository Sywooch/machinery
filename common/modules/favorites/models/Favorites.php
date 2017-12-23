<?php

namespace common\modules\favorites\models;

use common\models\Advert;
use yii;

/**
 * This is the model class for table "wishlist".
 *
 * @property integer $id
 * @property integer $entity_id
 * @property string $model
 * @property integer $user_id
 */
class Favorites extends \yii\db\ActiveRecord
{ 
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'favorites';
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

    /**
     * @return yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(FavoritesCategory::class, ['favorite_id' => 'id']);
    }

    public function getAdvert(){
        return $this->hasOne(Advert::class, ['id' => 'entity_id'])->where(['model'=>'Advert']);
    }
    
}

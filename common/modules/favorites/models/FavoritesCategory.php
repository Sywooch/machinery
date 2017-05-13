<?php

namespace common\modules\favorites\models;

use yii;

/**
 * This is the model class for table "favorites_category".
 *
 * @property integer $id
 * @property integer $favorite_id
 * @property integer $category_id
 */
class FavoritesCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'favorites_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['favorite_id', 'category_id'], 'required'],
            [['favorite_id', 'category_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'favorite_id' => 'Favorite ID',
            'category_id' => 'Category ID',
        ];
    }
}

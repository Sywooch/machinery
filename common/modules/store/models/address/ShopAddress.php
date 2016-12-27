<?php

namespace common\modules\store\models\address;

use Yii;

/**
 * This is the model class for table "shop_address".
 *
 * @property integer $id
 * @property string $title
 * @property string $address
 * @property string $coordinates
 * @property string $work_time
 */
class ShopAddress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'address', 'coordinates', 'work_time'], 'required'],
            [['title', 'work_time'], 'string', 'max' => 50],
            [['address', 'coordinates'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'address' => 'Address',
            'coordinates' => 'Coordinates',
            'work_time' => 'Work Time',
        ];
    }
}

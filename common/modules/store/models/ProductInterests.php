<?php

namespace common\modules\store\models;

use Yii;

/**
 * This is the model class for table "product_interests".
 *
 * @property integer $id
 * @property string $sku
 * @property integer $shows
 * @property string $date
 */
class ProductInterests extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_interests';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sku', 'ip'], 'required'],
            [['date'], 'safe'],
            [['ip'], 'string'],
            [['sku'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sku' => 'Sku',
            'shows' => 'Shows',
            'date' => 'Date',
            'ip' => 'Ip',
        ];
    }
    
    public static function push($product){
        
        $item = (new \yii\db\Query())
            ->select(['id'])
            ->from(self::tableName())
            ->where([
                'date' => date('Y-m-d'),
                'sku' => $product->sku,
                'ip' => $_SERVER['REMOTE_ADDR'],
            ])
            ->one();
        
        if(!$item){
          Yii::$app->db->createCommand()->insert(self::tableName(), [
                'sku' => $product->sku,
                'date' => date('Y-m-d'),
                'ip' => $_SERVER['REMOTE_ADDR'],
            ])->execute();  
        }
        
        
    }
}

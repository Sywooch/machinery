<?php

namespace common\modules\orders\models;

use Yii;
use common\helpers\ModelHelper;

/**
 * This is the model class for table "promo_products".
 *
 * @property integer $id
 * @property integer $code_id
 * @property integer $entity_id
 * @property string $model
 *
 * @property PromoCodes $code
 */
class PromoProducts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'promo_products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code_id', 'entity_id', 'model'], 'required'],
            [['code_id', 'entity_id'], 'integer'],
            [['model'], 'string', 'max' => 50],
            [['code_id'], 'exist', 'skipOnError' => true, 'targetClass' => PromoCodes::className(), 'targetAttribute' => ['code_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code_id' => 'Code ID',
            'entity_id' => 'Entity ID',
            'model' => 'Model',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCode()
    {
        return $this->hasOne(PromoCodes::className(), ['id' => 'code_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductTitle()
    {
        $product  = $this->hasOne(ModelHelper::getModelClass($this->model), ['id' => 'entity_id'])->one();
        return $product->title;
    }
    
    
}

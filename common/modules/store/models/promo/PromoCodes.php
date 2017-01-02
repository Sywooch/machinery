<?php

namespace common\modules\store\models\promo;

use Yii;
use common\modules\store\models\promo\PromoProducts;
use common\modules\store\models\order\OrderItemInterface;
/**
 * This is the model class for table "promo_codes".
 *
 * @property integer $id
 * @property string $code
 * @property integer $count
 * @property integer $discount
 * @property string $time
 */
class PromoCodes extends \yii\db\ActiveRecord implements OrderItemInterface
{
    const PROMO_CODE = 'promo-code';
    const SCENARIO_FIND = 'find';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'promo_codes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'discount'], 'required'],
            [['count', 'discount'], 'integer'],
            [['code'], 'string', 'max' => 50],
            [['time'],'safe'],
            [['code'], 'unique'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_FIND] = ['discount'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Промо код',
            'count' => 'Count',
            'discount' => 'Discount',
            'time' => 'Time',
        ];
    }
    
    public function getSku(){
        return self::PROMO_CODE;
    }
    public function getTitle(){
        return $this->code;
    }
    public function getPrice(){
        return $this->discount;
    }
}

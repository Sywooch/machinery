<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "package_option".
 *
 * @property integer $id
 * @property integer $package_id
 * @property integer $option_id
 *
 * @property TarifOptions $option
 * @property TarifPackages $package
 */
class PackageOption extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'package_option';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['package_id', 'option_id'], 'integer'],
            [['option_id'], 'exist', 'skipOnError' => true, 'targetClass' => TarifOptions::className(), 'targetAttribute' => ['option_id' => 'id']],
            [['package_id'], 'exist', 'skipOnError' => true, 'targetClass' => TarifPackages::className(), 'targetAttribute' => ['package_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'package_id' => Yii::t('app', 'Package ID'),
            'option_id' => Yii::t('app', 'Option ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOption()
    {
        return $this->hasOne(TarifOptions::className(), ['id' => 'option_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPackage()
    {
        return $this->hasOne(TarifPackages::className(), ['id' => 'package_id']);
    }
}

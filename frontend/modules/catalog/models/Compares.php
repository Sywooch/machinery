<?php

namespace frontend\modules\catalog\models;

use Yii;

/**
 * This is the model class for table "compares".
 *
 * @property integer $id
 * @property string $session
 * @property integer $entity_id
 * @property string $model
 */
class Compares extends \yii\db\ActiveRecord
{
    const MAX_ITEMS_COMPARE = 100;
        
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'compares';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['session', 'entity_id', 'term_id', 'model'], 'required'],
            [['term_id','entity_id'], 'integer'],
            [['session', 'model'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'session' => 'Session',
            'entity_id' => 'Entity ID',
            'model' => 'Model',
        ];
    }
    
    public static function getItems(){
        return self::find()->where([
                'session' => $_COOKIE['PHPSESSID']
             ])
             ->limit(self::MAX_ITEMS_COMPARE)
             ->orderBy([
                 'id' =>  SORT_DESC
             ])
             ->all();
    }
    
    public static function getCount(){
        return $subQuery = (new \yii\db\Query())->select('COUNT(id)')
                ->from(self::tableName())
                ->where([
                    'session' => $_COOKIE['PHPSESSID']
                ])
                ->count();
    }
}

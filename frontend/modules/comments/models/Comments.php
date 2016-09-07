<?php

namespace frontend\modules\comments\models;

use Yii;
use frontend\modules\rating\components\RatingValidator;

class Comments extends \yii\db\ActiveRecord {

    public $verifyCode;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'comments';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        $return = [
            [['comment', 'entity_id', 'model'], 'required'],
            [['feed_back'], 'required', 'when' => function($e){
                return !Yii::$app->user->id;
            }],
            [['id', 'user_id', 'parent_id', 'entity_id', 'created_at'], 'integer'],
            [['name', 'feed_back'], 'string', 'max' => 255],
            [['comment','negative','positive'], 'string', 'max' => 6000],
            [['model'], 'string', 'max' => 50],
            [['ip'], 'string', 'max' => 30],
            [['rating'], RatingValidator::class],
        ];
            
        if(!Yii::$app->user->id){
           $return[] = ['verifyCode', 'captcha'];
        }    
            
        return $return;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'comment' => 'Отзыв',
            'name' => 'Ваше имя',
            'verifyCode' => 'Проверочный код',
            'feed_back' => 'Контакты(телефон,E-mail)',
            'positive' => 'Положительные стороны',
            'negative' => 'Негативные стороны'
        ];
    }
    
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
                [
                    'class' => \frontend\modules\comments\components\CommentsBehavior::class
                ],
                [
                    'class' => \frontend\modules\rating\components\RatingBehavior::class,
                ]
            ];
    }
 
}

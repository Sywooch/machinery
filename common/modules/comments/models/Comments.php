<?php

namespace common\modules\comments\models;

use common\models\User;
use yii;
use yii\db\ActiveRecord;

class Comments extends ActiveRecord
{

    public $verifyCode;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $return = [
            [['comment'], 'required'],
            [['feed_back'], 'required', 'when' => function ($e) {
                return Yii::$app->user->isGuest;
            }],
            [['id', 'user_id', 'parent_id', 'entity_id', 'created_at'], 'integer'],
            [['name', 'feed_back'], 'string', 'max' => 255],
            [['comment', 'negative', 'positive'], 'string', 'max' => 6000],
            [['model'], 'string', 'max' => 50],
            [['ip'], 'string', 'max' => 30],
        ];

        if (Yii::$app->user->isGuest) {
            $return[] = ['verifyCode', 'captcha'];
        }

        return $return;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'comment' => 'Отзыв',
            'name' => 'Ваше имя',
            'verifyCode' => 'Проверочный код',
            'feed_back' => 'Контакты(телефон,E-mail)',
            'positive' => 'Положительные стороны',
            'negative' => 'Негативные стороны',
            'rating' => 'Рейтинг:'
        ];
    }



    /**
     * @return yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}

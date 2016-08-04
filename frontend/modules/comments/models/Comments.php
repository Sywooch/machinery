<?php

namespace frontend\modules\comments\models;

use Yii;
use yii\helpers\Html;
use frontend\modules\comments\models\CommentsRepository;
use frontend\modules\comments\helpers\CommentsHelper;

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
            [['ip'], 'string', 'max' => 30]
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

    /** @inheritdoc */
    public function beforeSave($insert) {
        if ($insert && !$this->id) {
            if ($this->parent_id == 0) {
                $maxThread = CommentsRepository::getMaxThread();
                $thread = CommentsHelper::int2vancode(CommentsHelper::vancode2int(CommentsHelper::getFirstThreadSegment($maxThread)) + 1) . '/';
            } else {
                $parent = Comments::findOne($this->parent_id);
                $thread = (string) rtrim((string) $parent->thread, '/'); 
                $maxThread = CommentsRepository::getMaxThread($thread); 
                if ($maxThread == '') {
                    $thread = $thread . '.' . CommentsHelper::int2vancode(0) . '/';
                } else {
                    $thread = $thread . '.' . CommentsHelper::int2vancode(CommentsHelper::vancode2int(CommentsHelper::getLastThreadSegment($maxThread)) + 1) . '/';
                }
            }
            $this->created_at = time();
            $this->thread = $thread;
            $this->user_id = \Yii::$app->user->id;
            $this->ip = $_SERVER['REMOTE_ADDR'];
        }
        return parent::beforeSave($insert);
    }
    
    public function afterSave($a, $b) {
        //CommentsHelper::sendNotifyNewComment($this);
        return parent::afterSave($a, $b);
    }
    
}

<?php

namespace frontend\modules\comments\helpers;

use Yii;
use yii\helpers\Html;
use frontend\modules\comments\models\Comments;


class CommentsHelper {
    
    /**
     * 
     * @param int $i
     * @return string
     */
    public static function int2vancode($i = 0) {
        $num = base_convert((int) $i, 10, 36);
        $length = strlen($num);
        return chr($length + ord('0') - 1) . $num;
    }
    
    /**
     * 
     * @param string $c
     * @return string
     */
    public static  function vancode2int($c = '00') {
        return base_convert(substr($c, 1), 36, 10);
    }
    
    /**
     * 
     * @param string $max
     * @return string
     */
    public static function getFirstThreadSegment($max){
        $max = rtrim($max, '/');
        $parts = explode('.', $max);
        return current($parts);
    }
    
    /**
     * 
     * @param string $max
     * @return string
     */
    public static function getLastThreadSegment($parentThread, $max){
        $max = rtrim($max, '/');
        $parts = explode('.', $max);
        $parentDepth = count(explode('.', $parentThread));
        return  $parts[$parentDepth];
    }
    
    /**
     * 
     * @param Comments $model
     */
    public static function sendNotifyNewComment(Comments $model){
         Yii::$app->mailer->compose('@app/modules/comments/views/default/mail', [
                        'text' => Html::encode($model->comment)
                    ])
                    ->setTo(Yii::$app->params['adminEmail'])
                    ->setFrom(['noreply@site.com' => 'Магаз'])
                    ->setSubject('Новый отзыв с Магазина')
                    ->send();
    }
    
    public static function getToken($comment){
        return  md5('answer' . $comment['id'] . $comment['created_at'] . Yii::$app->user->id . Yii::$app->request->cookieValidationKey);
    }
    
}
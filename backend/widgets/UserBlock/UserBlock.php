<?php


namespace backend\widgets\UserBlock;

use Yii;

class UserBlock extends \yii\bootstrap\Widget
{
    

    /**
     * @var array the options for rendering the tag.
     */
    public $type = 0;

    
    public function run()
    {
        
        $model = \dektrium\user\models\User::findOne(Yii::$app->user->id);
        
        return $this->render('user-block', [
                'model' => $model,
                'type' => $this->type,
            ]);
    }
}

<?php
namespace common\models;

class User extends \dektrium\user\models\User{
    
     /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = [['avatar'], 'file', 'extensions' => 'jpg, png', 'mimeTypes' => 'image/jpeg, image/png', 'maxFiles' => 1];
        return $rules;
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors[] = \common\modules\file\components\FileBehavior::class;
      
        return $behaviors;
    }
    
}


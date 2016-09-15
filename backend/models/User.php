<?php

namespace backend\models;

use dektrium\user\models\User as UserBase;


class User extends UserBase
{
   
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

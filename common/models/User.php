<?php
namespace common\models;

use common\modules\file\models\File;
use yii\helpers\StringHelper;

class User extends \dektrium\user\models\User{
    
     /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = [['photo'], 'file', 'extensions' => 'jpg, png', 'mimeTypes' => 'image/jpeg, image/png', 'maxFiles' => 2];
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

    public function getAvatar(){
        return $this->hasOne(File::class,['entity_id' => 'id'])->where([
            'model' => StringHelper::basename(self::class)
        ]);
    }
    
}


<?php

namespace common\modules\file\models;

use Yii;
use yii\web\UploadedFile;

class FileValidator extends \yii\base\Model
{
    /** @var UploadedFile|Null file attribute */
    public $files;
    
    /** @var array $rule */
    public $rule;

    /**
     * @inheritdoc
     */
    public function rules()
    {        
        if(!empty($this->rule)){
            $this->rule[0] = ['files'];
            return [$this->rule];
        }
        return [];
    }
}

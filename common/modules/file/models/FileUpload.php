<?php

namespace common\modules\file\models;

use Yii;
use yii\web\UploadedFile;
use yii\base\Model;

class FileUpload extends Model
{

    /**
     * @var UploadedFile|Null file attribute
     */
    public $instances;

    /**
     * @var array $rule
     */
    public $rule;

    /**
     * @var string $field
     */
    public $field;

    /**
     * @var array File
     */
    public $files;

    /**
     * @var object $entity
     */
    public $entity;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        $this->rule[0] = 'instances';
        $rules[] = [['files', 'instances'], 'required'];
        $rules[] = $this->rule;
        $rules[] = ['files', 'validateFilesCallback'];
        return $rules;
    }

    /**
     *
     * @param string $field
     * @return boolean
     */
    public function validateFilesCallback($field)
    {
        foreach ($this->{$field} as $file) {
            $file->scenario = $file::SCENARIO_ENTITY_VALIDATE;
            if (!$file->validate()) {
                $this->addError($field, 'File: ' . current(current($file->getErrors())));
                return false;
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function beforeValidate()
    {
        if (isset($this->rule['maxFiles']) && $this->rule['maxFiles'] == 1) {
            $this->instances = reset($this->instances);
        }
        return parent::beforeValidate();
    }


    /**
     * 
     */
    public function save()
    {
        foreach ($this->files as $file) {
            $file->entity_id = $this->entity->id;
            $file->save(false);
        }
    }

}

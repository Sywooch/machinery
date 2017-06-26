<?php

namespace common\modules\file\components;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use common\modules\file\helpers\FileHelper;
use common\modules\file\Uploader;
use common\modules\file\Finder;
use common\modules\file\models\FileRepository;

class FileBehavior extends Behavior
{

    /**
     * @var string
     */
    public $countField;

    /**
     * @var array
     */
    protected $_fileFields;

    /**
     * @var Uploader
     */
    protected $_uploader;

    /**
     * @var FileRepository
     */
    protected $_repository;

    public function __construct(FileRepository $repository, Uploader $uploader, array $config = [])
    {
        $this->_repository = $repository;
        $this->_uploader = $uploader;
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
            ActiveRecord::EVENT_INIT => 'afterInit',
        ];
    }

    /**
     * @inheritdoc
     */
    public function afterInit()
    {
        $this->_fileFields = FileHelper::getFileFields($this->owner);
    }

    /**
     * @param string $name
     * @param bool $checkVars
     * @return bool
     */
    public function canGetProperty($name, $checkVars = true)
    {
        if (isset($this->_fileFields[$name])) {
            if (!isset($this->$name)) {
                $this->$name = Finder::getInstances($this->owner, $name);
            }
            return true;
        }
        parent::canGetProperty($name, $checkVars);
    }

    /**
     * @param string $name
     * @param bool $checkVars
     * @return bool
     */
    public function canSetProperty($name, $checkVars = true)
    {
        if (isset($this->_fileFields[$name])) {
            return true;
        }
        parent::canSetProperty($name, $checkVars);
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        if (isset($this->_fileFields[$name])) {
            $this->{$name} = $value;
        }
    }

    /**
     * @inheritdoc
     */
    public function beforeValidate()
    {
        $this->_uploader->getInstances($this->owner);
        foreach ($this->_fileFields as $rules) {
            $field = current($rules);
            $maxFiles = FileHelper::maxFiles($this->owner, $field);
            $uploads = $this->_uploader->getUploads($field);
            $this->owner->{$field} = Finder::getInstances($this->owner, $field)->all();
            if ($maxFiles && count($this->owner->{$field}) + count($uploads) > $maxFiles) {
                $this->owner->addError($field, "Max files is $maxFiles. Delete excess.");
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function afterSave()
    {
        $this->_uploader->save($this->owner);
        if ($this->countField) {
            $model = $this->owner;
            $model::updateAll([$this->countField => (int)$this->_repository->count($this->owner->id)], ['id' => $this->owner->id]);
        }
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        foreach ($this->_fileFields as $rules) {
            $field = current($rules);
            foreach ($this->owner->{$field} as $instance) {
                $instance->delete();
            }
        }
    }
}
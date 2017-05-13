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
    private $_fileFields;

    /**
     * @var FileRepository
     */
    private $_repository;

    public function __construct(FileRepository $repository, array $config = [])
    {
        $this->_repository = $repository;
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'afterSave',
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
            $this->$name = $value;
        }
    }

    /**
     * @inheritdoc
     */
    public function afterSave()
    {
       Uploader::save($this->owner);
        if($this->countField){
            $model = $this->owner;
            $model::updateAll([$this->countField => (bool)$this->_repository->count($this->owner->id)], ['id' => $this->owner->id]);
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
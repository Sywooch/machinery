<?php
namespace common\modules\file;

use Yii;
use common\modules\file\filestorage\Storage;

class Module extends \yii\base\Module
{
    /**
     * @var array Storage
     */
    public $storages;

    /**
     * @var Storage
     */
    public $storage;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->createStorages();
        parent::init();
    }

    /**
     * @throws InvalidStorageException
     * @throws \yii\base\InvalidConfigException
     */
    private function createStorages()
    {
        $storages = [];
        foreach ($this->storages as $name => $config) {
            $class = array_shift($config);
            $storage = new $class($config);
            if (!($storage instanceof Storage)) {
                throw new InvalidStorageException();
            }
            $storages[] = $storage;
        }
        $this->storages = $storages;
        $this->storage = Yii::$container->get($this->storage);
    }
}

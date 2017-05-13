<?php

namespace common\modules\file\filestorage\storages;

use yii\helpers\StringHelper;
use common\modules\file\models\File;
use common\modules\file\filestorage\StorageDbInterface;
use common\modules\file\filestorage\StorageInterface;

class StorageDb implements StorageDbInterface
{

    /**
     * @var int
     */
    private $_delta;

    /**
     * @var File
     */
    private $_file;

    /**
     * {@inheritdoc}
     */
    public function __construct(File $file, array $config = [])
    {
        $this->_file = $file;
    }

    /**
     * {@inheritdoc}
     */
    public function save(StorageInterface $storage) : bool
    {
        $file = clone $this->_file;
        $file->entity_id = $storage->getEntity()->id;
        $file->field = $storage->getField();
        $file->model = StringHelper::basename(get_class($storage->getEntity()));
        $file->name = $storage->getName();
        $file->path = $storage->getUrl();
        $file->size = $storage->getInstance()->size;
        $file->mimetype = $storage->getInstance()->type;
        $file->delta = $this->getDelta($storage->getField());
        $file->storage = StringHelper::basename(get_class($storage));
        return $file->save();
    }

    /**
     * @param string $field
     * @return int
     */
    private function getDelta(string $field) : int
    {
        if (!isset($this->_delta[$field])) {
            $this->_delta[$field] = -1;
        }
        $this->_delta[$field]++;
        return $this->_delta[$field];
    }
}

<?php

namespace common\modules\file\filestorage\storages;

use yii\helpers\Url;
use yii\helpers\FileHelper;
use common\modules\file\filestorage\Storage;
use yii\helpers\StringHelper;
use common\modules\file\filestorage\InstanceInterface;

class StorageLocal extends Storage
{

    /**
     * @var string
     */
    public $basePath;

    /**
     * @var string
     */
    public $baseUrl;

    /**
     * {@inheritdoc}
     */
    public function save() : bool
    {
        FileHelper::createDirectory($this->getUploadPath());
        return $this->_instance->saveAs($this->getUploadPath() . '/' . $this->getName());
    }

    /**
     * @return string
     */
    private function getUploadPath() : string
    {
        return $this->getPath(StringHelper::basename(get_class($this->_entity)), $this->_field);
    }

    /**
     * @param string $model
     * @param string $field
     * @return string
     */
    private function getPath(string $model, string $field) : string
    {
        return strtolower(Url::to($this->basePath) . '/' . $model . '/' . $field);
    }

    /**
     * {@inheritdoc}
     */
    public function getName() : string
    {
        return $this->_entity->id . '_' . $this->_instance->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getUrl() : string
    {
        return strtolower(Url::to($this->baseUrl) . '/' . StringHelper::basename(get_class($this->_entity)) . '/' . $this->_field);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(InstanceInterface $instance)
    {
        $file = $this->getPath($instance->model, $instance->field) . '/' . $instance->name;
        if (is_file($file)) {
            unlink($this->getPath($instance->model, $instance->field) . '/' . $instance->name);
        }
    }

}

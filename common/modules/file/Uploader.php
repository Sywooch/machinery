<?php

namespace common\modules\file;

use Yii;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use common\modules\file\helpers\FileHelper;
use yii\db\ActiveRecordInterface;

class Uploader
{

    /**
     * @var array
     */
    private $_uploads = [];

    public $result;

    /**
     * @param ActiveRecordInterface $entity
     */
    public function getInstances($entity)
    {
        $fields = FileHelper::getFileFields($entity);
        foreach ($fields as $rule) {
            $field = $rule[0];
            $this->_uploads[$field] = UploadedFile::getInstances($entity, $field);
        }
    }

    /**
     * @param ActiveRecordInterface $entity
     * @return bool
     */
    public function save(ActiveRecordInterface $entity)
    {
        $fields = FileHelper::getFileFields($entity);
        $this->result = false;
        foreach ($fields as $rule) {
            $field = current($rule);
            $this->upload($this->_uploads[$field] ?? [], $entity, $field);
        }

        return $this->result;
    }

    /**
     * @param array $instances
     * @param ActiveRecord $entity
     * @param string $field
     * @return bool
     */
    private function upload(array $instances, ActiveRecord $entity, string $field)
    {
        if (empty($instances)) {
            return false;
        }

        $module = Yii::$app->getModule('file');

        foreach ($instances as $instance) {

            if (!($instance instanceof UploadedFile)) {
                continue;
            }

            foreach ($module->storages as $storage) {
                $storage->setEntity($entity);
                $storage->setInstance($instance);
                $storage->setField($field);
                if ($storage->save()) {
                    $module->storage->save($storage);
                    $this->result = true;
                }
            }
        }
    }

    /**
     * @param null $field
     * @return array
     */
    public function getUploads($field = null): array
    {
        if ($field) {
            return $this->_uploads[$field] ?? [];
        }
        return $this->_uploads;
    }

}

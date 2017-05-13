<?php
namespace common\modules\file\filestorage;
use yii\db\ActiveRecordInterface;
use yii\web\UploadedFile;

interface StorageInterface{

    /**
     * @return ActiveRecordInterface
     */
    public function getEntity() : ActiveRecordInterface;

    /**
     * @param ActiveRecordInterface $entity
     */
    public function setEntity(ActiveRecordInterface $entity);

    /**
     * @return UploadedFile
     */
    public function getInstance() : UploadedFile;

    /**
     * @param UploadedFile $instance
     */
    public function setInstance(UploadedFile $instance);

    /**
     * @return string
     */
    public function getField();

    /**
     * @param string $field
     */
    public function setField(string $field);

    /**
     * @return bool
     */
    public function save() : bool;

    /**
     * @return string
     */
    public function getName() : string;

    /**
     * @return string
     */
    public function getUrl() : string;

    /**
     * @param InstanceInterface $instance
     */
    public function delete(InstanceInterface $instance);
}
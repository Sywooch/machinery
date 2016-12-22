<?php
namespace common\modules\file\filestorage;
use yii\db\ActiveRecordInterface;
use yii\web\UploadedFile;

interface StorageInterface{
    public function getEntity();
    public function setEntity(ActiveRecordInterface $entity);
    public function getInstance();
    public function setInstance(UploadedFile $instance);
    public function getField();
    public function setField(string $field);
    public function save();
    public function getName();
    public function getUrl();
    public function delete(InstanceInterface $instance);
}
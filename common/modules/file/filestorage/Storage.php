<?php
namespace common\modules\file\filestorage;

use yii\db\ActiveRecordInterface;
use yii\web\UploadedFile;
use yii\base\Object;

abstract class Storage extends Object implements StorageInterface
{

    /**
     * @var ActiveRecordInterface
     */
    protected $_entity;

    /**
     * @var string
     */
    protected $_field;

    /**
     * @var UploadedFile
     */
    protected $_instance;

    /**
     * Storage constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        foreach ($config as $key => $value) {
            $this->{$key} = $value;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity() : ActiveRecordInterface
    {
        return $this->_entity;
    }

    /**
     * {@inheritdoc}
     */
    public function setEntity(ActiveRecordInterface $entity)
    {
        $this->_entity = $entity;
    }

    /**
     * {@inheritdoc}
     */
    public function getInstance() : UploadedFile
    {
        return $this->_instance;
    }

    /**
     * {@inheritdoc}
     */
    public function setInstance(UploadedFile $instance)
    {
        $this->_instance = $instance;
    }

    /**
     * {@inheritdoc}
     */
    public function getField()
    {
        return $this->_field;
    }

    /**
     * {@inheritdoc}
     */
    public function setField(string $field)
    {
        $this->_field = $field;
    }

}


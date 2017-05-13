<?php
namespace common\modules\file\filestorage;

use common\modules\file\models\File;
use common\modules\file\filestorage\StorageInterface;

interface StorageDbInterface
{
    /**
     * StorageDbInterface constructor.
     * @param File $file
     * @param array $config
     */
    public function __construct(File $file, array $config = []);

    /**
     * @param \common\modules\file\filestorage\StorageInterface $storage
     * @return bool
     */
    public function save(StorageInterface $storage) : bool;
}
<?php
namespace common\modules\file\filestorage;

use common\modules\file\models\File;
use common\modules\file\filestorage\StorageInterface;

interface StorageDbInterface{
    public function __construct(File $file, array $config = []);
    public function save(StorageInterface $storage);
}
<?php
namespace common\modules\file\filestorage;

use yii\db\ActiveRecordInterface;

interface InstanceInterface extends ActiveRecordInterface{
    public function delete();
}
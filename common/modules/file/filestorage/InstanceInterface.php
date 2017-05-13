<?php
namespace common\modules\file\filestorage;

use yii\db\ActiveRecordInterface;

interface InstanceInterface extends ActiveRecordInterface
{
    /**
     * delete file instance
     *
     * @return void
     */
    public function delete();
}